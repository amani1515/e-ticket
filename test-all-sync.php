<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing All Models with Sync...\n";
echo "===============================\n\n";

$models = [
    'App\Models\User',
    'App\Models\Ticket', 
    'App\Models\CashReport',
    'App\Models\Schedule',
    'App\Models\Bus',
    'App\Models\Destination',
    'App\Models\Mahberat',
    'App\Models\Cargo'
];

foreach ($models as $model) {
    $modelName = class_basename($model);
    echo "Testing {$modelName}...\n";
    
    try {
        // Check if model uses Syncable trait
        $reflection = new ReflectionClass($model);
        $traits = $reflection->getTraitNames();
        
        if (in_array('App\Traits\Syncable', $traits)) {
            echo "✅ {$modelName} has Syncable trait\n";
            
            // Check if table has sync columns
            $instance = new $model;
            $fillable = $instance->getFillable();
            
            if (in_array('uuid', $fillable) && in_array('synced', $fillable)) {
                echo "✅ {$modelName} has sync fields\n";
            } else {
                echo "❌ {$modelName} missing sync fields\n";
            }
        } else {
            echo "❌ {$modelName} missing Syncable trait\n";
        }
        
    } catch (Exception $e) {
        echo "❌ {$modelName} error: " . $e->getMessage() . "\n";
    }
    
    echo "\n";
}

echo "Now create some test data to see sync in action!\n";
?>