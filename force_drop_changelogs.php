<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

// Force Drop
Schema::dropIfExists('changelogs');
DB::table('migrations')->where('migration', 'like', '%changelogs%')->delete();

echo "Force Dropped changelogs table and cleared migration history.\n";
