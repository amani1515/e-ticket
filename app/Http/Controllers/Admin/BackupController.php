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


public function backupDownload()
{
    if (Auth::check() && Auth::user()->usertype === 'admin') {
        $timestamp = now()->format('d-m-Y_H-i-s');
        $backupFolder = storage_path("app/backup_temp_$timestamp");
        File::makeDirectory($backupFolder, 0755, true);

        // MySQL credentials
        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');

        $sqlFile = "$backupFolder/{$dbName}_backup.sql";
        $escapedPass = str_replace('"', '\"', $dbPass);

        // Dump command
        $command = "mysqldump -h $dbHost -u $dbUser -p\"$escapedPass\" $dbName > \"$sqlFile\"";
        $result = null;
        $output = null;
        exec($command, $output, $result);

        if (!file_exists($sqlFile)) {
            File::deleteDirectory($backupFolder);
            return back()->with('error', 'Database backup failed. Make sure mysqldump is installed and DB credentials are correct.');
        }

        // ZIP the backup
        $zipFile = storage_path("app/backup_eticket_{$timestamp}.zip");
        $zip = new ZipArchive;
        if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
            $zip->addFile($sqlFile, basename($sqlFile));
            $zip->close();
        } else {
            File::deleteDirectory($backupFolder);
            return back()->with('error', 'Failed to create ZIP file.');
        }

        File::deleteDirectory($backupFolder);
        return response()->download($zipFile)->deleteFileAfterSend(true);
    }

    abort(403);
}

}
