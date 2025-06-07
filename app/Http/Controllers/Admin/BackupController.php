<?php

namespace App\Http\Controllers\Admin;

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use ZipArchive;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BackupController extends Controller
{
    public function download()
    {
        if (Auth::check() && Auth::user()->usertype === 'admin') {

            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $backupFolder = storage_path("app/backup_{$timestamp}");
            File::makeDirectory($backupFolder);

            // 1. Export Database
            $dbName = env('DB_DATABASE');
            $dbUser = env('DB_USERNAME');
            $dbPass = env('DB_PASSWORD');
            $dbHost = env('DB_HOST');
            $sqlFile = "$backupFolder/{$dbName}_backup.sql";

$command = sprintf('mysqldump -u%s -p%s -h%s %s > %s', $dbUser, $dbPass, $dbHost, $dbName, $sqlFile);
            $result = null;
            $output = null;
            exec($command, $output, $result);

            if ($result !== 0) {
                File::deleteDirectory($backupFolder);
                return back()->with('error', 'Failed to back up the database.');
            }

            // 2. Zip project (excluding vendor and node_modules)
            $zipFile = storage_path("app/backup_{$timestamp}.zip");
            $zip = new ZipArchive;
            if ($zip->open($zipFile, ZipArchive::CREATE) === true) {
                $rootPath = base_path();

                $exclude = ['vendor', 'node_modules', '.git'];

                $files = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($rootPath),
                    \RecursiveIteratorIterator::LEAVES_ONLY
                );

                foreach ($files as $name => $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        $relativePath = str_replace($rootPath . DIRECTORY_SEPARATOR, '', $filePath);

                        $shouldExclude = false;
                        foreach ($exclude as $folder) {
                            if (str_starts_with($relativePath, $folder)) {
                                $shouldExclude = true;
                                break;
                            }
                        }

                        if (!$shouldExclude) {
                            $zip->addFile($filePath, $relativePath);
                        }
                    }
                }

                // Add SQL backup
                $zip->addFile($sqlFile, "database_backup.sql");

                $zip->close();
            }

            // Clean up temporary folder
            File::deleteDirectory($backupFolder);

            // Download the zip
            return response()->download($zipFile)->deleteFileAfterSend(true);
        }

        abort(403);
    }
}
