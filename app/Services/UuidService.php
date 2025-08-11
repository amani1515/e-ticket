<?php

namespace App\Services;

use Carbon\Carbon;

class UuidService
{
    /**
     * Generate meaningful UUIDs for different models
     */
    public static function generate(string $type, array $data = []): string
    {
        $timestamp = Carbon::now()->format('ymdHis'); // 240115143022
        $random = strtoupper(substr(md5(uniqid()), 0, 6));
        
        switch ($type) {
            case 'user':
                $prefix = 'USR';
                $userType = strtoupper(substr($data['usertype'] ?? 'GEN', 0, 3));
                return "{$prefix}-{$userType}-{$timestamp}-{$random}";
                
            case 'ticket':
                $prefix = 'TKT';
                $destination = strtoupper(substr($data['destination'] ?? 'GEN', 0, 3));
                return "{$prefix}-{$destination}-{$timestamp}-{$random}";
                
            case 'schedule':
                $prefix = 'SCH';
                $mahberat = strtoupper(substr($data['mahberat'] ?? 'GEN', 0, 3));
                return "{$prefix}-{$mahberat}-{$timestamp}-{$random}";
                
            case 'bus':
                $prefix = 'BUS';
                $level = strtoupper(substr($data['level'] ?? 'L1', 0, 2));
                return "{$prefix}-{$level}-{$timestamp}-{$random}";
                
            case 'cash_report':
                $prefix = 'CSH';
                $user = strtoupper(substr($data['user_name'] ?? 'USR', 0, 3));
                return "{$prefix}-{$user}-{$timestamp}-{$random}";
                
            case 'destination':
                $prefix = 'DST';
                $name = strtoupper(substr($data['name'] ?? 'GEN', 0, 3));
                return "{$prefix}-{$name}-{$timestamp}-{$random}";
                
            case 'mahberat':
                $prefix = 'MHB';
                $name = strtoupper(substr($data['name'] ?? 'GEN', 0, 3));
                return "{$prefix}-{$name}-{$timestamp}-{$random}";
                
            case 'cargo':
                $prefix = 'CRG';
                $destination = strtoupper(substr($data['destination'] ?? 'GEN', 0, 3));
                return "{$prefix}-{$destination}-{$timestamp}-{$random}";
                
            default:
                $prefix = 'GEN';
                return "{$prefix}-{$timestamp}-{$random}";
        }
    }
    
    /**
     * Extract information from UUID
     */
    public static function decode(string $uuid): array
    {
        $parts = explode('-', $uuid);
        
        if (count($parts) < 4) {
            return ['type' => 'unknown', 'timestamp' => null, 'category' => null];
        }
        
        return [
            'type' => $parts[0],
            'category' => $parts[1] ?? null,
            'timestamp' => $parts[2] ?? null,
            'random' => $parts[3] ?? null
        ];
    }
}