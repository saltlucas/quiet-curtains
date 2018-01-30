<?phpdefined("ABSPATH") or die("");
if (!defined('DUPLICATOR_PRO_VERSION')) exit; // Exit if accessed directly

require_once (DUPLICATOR_PRO_PLUGIN_PATH.'classes/package/class.pack.archive.php');
require_once (DUPLICATOR_PRO_PLUGIN_PATH.'classes/entities/class.global.entity.php');
require_once (DUPLICATOR_PRO_PLUGIN_PATH.'classes/entities/class.system.global.entity.php');
require_once (DUPLICATOR_PRO_PLUGIN_PATH.'classes/entities/class.storage.entity.php');
require_once (DUPLICATOR_PRO_PLUGIN_PATH.'classes/utilities/class.u.shell.php');

/**
 *  Creates a zip file using Shell_Exec and the system zip command
 *  Not available on all system   */
class DUP_PRO_ShellZip extends DUP_PRO_Archive
{

    /**
     *  Creates the zip file and adds the SQL file to the archive   */
    public static function create(DUP_PRO_Archive $archive, $build_progress)
    {
        $timed_out = false;

        try {
            if ($archive->Package->Status == DUP_PRO_PackageStatus::ARCSTART) {
                $error_text = DUP_PRO_U::__('Zip process getting killed due to limited server resources.');
                $fix_text   = sprintf("%s <a href='https://snapcreek.com/duplicator/docs/faqs-tech/#faq-package-110-q' target='_blank'>%s</a>", DUP_PRO_U::__('See FAQ:'),
                    DUP_PRO_U::__('Why does the build percent grow and continually go back to 40%?'));

                $system_global = DUP_PRO_System_Global_Entity::get_instance();
                $system_global->add_recommended_text_fix($error_text, $fix_text);
                $system_global->save();

                DUP_PRO_LOG::traceError("$error_text  **RECOMMENDATION: $fix_text");

                if ($build_progress->retries > 1) {
                    $build_progress->failed = true;
                    return true;
                } else {
                    $build_progress->retries++;
                    $archive->Package->update();
                }
            }

            $archive->Package->Status = DUP_PRO_PackageStatus::ARCSTART;
            $archive->Package->update();
            $archive->Package->safe_tmp_cleanup(true);

            $global        = DUP_PRO_Global_Entity::get_instance();
            $timerAllStart = DUP_PRO_U::getMicrotime();

            $compressDir  = rtrim(DUP_PRO_U::safePath($archive->PackDir), '/');
            $zipPath      = DUP_PRO_U::safePath("{$archive->Package->StorePath}/{$archive->File}");
            $sql_filepath = DUP_PRO_U::safePath("{$archive->Package->StorePath}/{$archive->Package->Database->File}");

            $filterDirs  = empty($archive->FilterDirs) ? 'not set' : $archive->FilterDirs;
            $filterExts  = empty($archive->FilterExts) ? 'not set' : $archive->FilterExts;
            $filterFiles = empty($archive->FilterFiles) ? 'not set' : $archive->FilterFiles;
            $filterOn    = ($archive->FilterOn) ? 'ON' : 'OFF';

            //LOAD SCAN REPORT
            $json       = file_get_contents(DUPLICATOR_PRO_SSDIR_PATH_TMP."/{$archive->Package->NameHash}_scan.json");
            $scanReport = json_decode($json);

            DUP_PRO_Log::info("\n********************************************************************************");
            DUP_PRO_Log::info("ARCHIVE  Type=ZIP Mode=Shell");
            DUP_PRO_Log::info("********************************************************************************");
            DUP_PRO_Log::info("ARCHIVE DIR:  ".$compressDir);
            DUP_PRO_Log::info("ARCHIVE FILE: ".basename($zipPath));
            DUP_PRO_Log::info("FILTERS: *{$filterOn}*");
            DUP_PRO_Log::info("DIRS:  {$filterDirs}");
            DUP_PRO_Log::info("EXTS:  {$filterExts}");
            DUP_PRO_Log::info("FILES:  {$filterFiles}");
            DUP_PRO_Log::info("----------------------------------------");
            DUP_PRO_Log::info("COMPRESSING");
            DUP_PRO_Log::info("SIZE:\t".$scanReport->ARC->Size);
            DUP_PRO_Log::info("STATS:\tDirs ".$scanReport->ARC->DirCount." | Files ".$scanReport->ARC->FileCount." | Total ".$scanReport->ARC->FullCount);

            $contains_root  = false;
            $exclude_string = '';

            $filterDirs  = $archive->FilterDirsAll;
            $filterExts  = $archive->FilterExtsAll;
            $filterFiles = $archive->FilterFilesAll;

			//DIRS LIST
            foreach ($filterDirs as $filterDir) {
                if (trim($filterDir) != '') {
                    $relative_filter_dir = DUP_PRO_U::getRelativePath($compressDir, $filterDir);
                    DUP_PRO_LOG::trace("Adding relative filter dir $relative_filter_dir for $filterDir relative to $compressDir");
                    if (trim($relative_filter_dir) == '') {
                        $contains_root = true;
                        break;
                    } else {
                        $exclude_string .= "$relative_filter_dir**\* ";
                        $exclude_string .= "$relative_filter_dir ";
                    }
                }
            }

			//EXT LIST
            foreach ($filterExts as $filterExt) {
                $exclude_string .= "\*.$filterExt ";
            }

			//FILE LIST
            foreach ($filterFiles as $filterFile) {
                if (trim($filterFile) != '') {
                    $relative_filter_file = DUP_PRO_U::getRelativePath($compressDir, trim($filterFile));
                    DUP_PRO_LOG::trace("Full file=$filterFile relative=$relative_filter_file compressDir=$compressDir");
                    $exclude_string .= "\"$relative_filter_file\" ";
                }
            }

			//DB ONLY
			if ($archive->ExportOnlyDB) {
				$contains_root = true;
			}


            if ($contains_root == false) {
                // Only attempt to zip things up if root isn't in there since stderr indicates when it cant do anything
                $storages = DUP_PRO_Storage_Entity::get_all();
                foreach ($storages as $storage) {
                    if (($storage->storage_type == DUP_PRO_Storage_Types::Local) && $storage->local_filter_protection && ($storage->id != DUP_PRO_Virtual_Storage_IDs::Default_Local)) {
                        $storage_path = DUP_PRO_U::safePath($storage->local_storage_folder);
                        $storage_path = DUP_PRO_U::getRelativePath($compressDir, $storage_path);
                        $exclude_string .= "$storage_path**\* ";
                    }
                }

                $relative_backup_dir = DUP_PRO_U::getRelativePath($compressDir, DUPLICATOR_PRO_SSDIR_PATH);
                $exclude_string .= "$relative_backup_dir**\* ";

                $compression_parameter = DUP_PRO_Shell_U::getCompressionParam();

                $command = 'cd '.escapeshellarg($compressDir);
                $command .= ' && '.escapeshellcmd(DUP_PRO_Zip_U::getShellExecZipPath())." $compression_parameter".' -rq ';
                $command .= escapeshellarg($zipPath).' ./';
                $command .= " -x $exclude_string 2>&1";

                DUP_PRO_LOG::trace("Executing shellzip command $command");
                $stderr = shell_exec($command);
                DUP_PRO_LOG::trace("After shellzip command");

                if ($stderr != NULL) {
                    $error_text = "Error executing shell exec zip: $stderr.";

                    if (DUP_PRO_STR::contains($stderr, 'quota')) {
                        $fix_text = DUP_PRO_U::__("Account out of space so purge large files or talk to your host about increasing quota.");
                    } else if (DUP_PRO_STR::contains($stderr, 'such file or')) {
                        $fix_text = sprintf("%s <a href='https://snapcreek.com/duplicator/docs/faqs-tech/#faq-package-160-q' target='_blank'>%s</a>", DUP_PRO_U::__('See FAQ:'),
                            DUP_PRO_U::__('How to resolve "zip warning: No such file or directory"?'));
                    } else {
                        $fix_text = DUP_PRO_U::__("Go to: Settings > Packages Tab > Archive Engine to ZipArchive.");
                    }

                    /* @var $system_global DUP_PRO_System_Global_Entity */
                    $system_global = DUP_PRO_System_Global_Entity::get_instance();
                    $system_global->add_recommended_text_fix($error_text, $fix_text);
                    $system_global->save();

                    DUP_PRO_Log::error("$error_text  **RECOMMENDATION: $fix_text", '', false);

                    $build_progress->failed = true;
                    return true;
                } else {
                    DUP_PRO_LOG::trace("Stderr is null");
                }

                $file_count_string = '';

                if (!file_exists($zipPath)) {
                    $file_count_string = DUP_PRO_U::__("$zipPath doesn't exist!");
                } else if (DUP_PRO_U::getExeFilepath('zipinfo') != NULL) {
                    DUP_PRO_LOG::trace("zipinfo exists");
                    $file_count_string = "zipinfo -t '$zipPath'";
                } else if (DUP_PRO_U::getExeFilepath('unzip') != NULL) {
                    DUP_PRO_LOG::trace("zipinfo doesn't exist so reverting to unzip");
                    $file_count_string = "unzip -l '$zipPath' | wc -l";
                }

                if ($file_count_string != '') {
                    $file_count = DUP_PRO_Shell_U::runAndGetResponse($file_count_string, 1);

                    if (is_numeric($file_count)) {
                        // Accounting for the sql and installer back files
                        $archive->file_count = (int) $file_count + 2;
                    } else {
                        $error_text = DUP_PRO_U::__("Error retrieving file count in shell zip $file_count.");

                        DUP_PRO_LOG::trace("Executed file count string of $file_count_string");
                        DUP_PRO_LOG::trace($error_text);

                        $fix_text = DUP_PRO_U::__("Go to: Settings > Packages Tab > Archive Engine to ZipArchive.");

                        $system_global = DUP_PRO_System_Global_Entity::get_instance();
                        $system_global->add_recommended_text_fix($error_text, $fix_text);
                        $system_global->save();

                        DUP_PRO_Log::error("$error_text  **RECOMMENDATION:$fix_text", '', false);
                        DUP_PRO_LOG::trace("$error_text  **RECOMMENDATION:$fix_text");
                        $build_progress->failed = true;
                        $archive->file_count    = -2;
                        return true;
                    }
                } else {
                    DUP_PRO_LOG::trace("zipinfo doesnt exist");
                    // The -1 and -2 should be constants since they signify different things
                    $archive->file_count = -1;
                }
            } else {
                $archive->file_count = 2; // Installer bak and database.sql
            }

            DUP_PRO_LOG::trace("archive file count from shellzip is $archive->file_count");

            $build_progress->archive_built = true;
            $build_progress->retries       = 0;

            $archive->Package->update();

            $timerAllEnd = DUP_PRO_U::getMicrotime();
            $timerAllSum = DUP_PRO_U::elapsedTime($timerAllEnd, $timerAllStart);
            $zipFileSize = @filesize($zipPath);

            DUP_PRO_Log::info("COMPRESSED SIZE: ".DUP_PRO_U::byteSize($zipFileSize));
            DUP_PRO_Log::info("ARCHIVE RUNTIME: {$timerAllSum}");
            DUP_PRO_Log::info("MEMORY STACK: ".DUP_PRO_Server::getPHPMemory());
        } catch (Exception $e) {
            DUP_PRO_Log::error("Runtime error in shell exec zip compression.", "Exception: {$e}");
        }

        return true;
    }
}
