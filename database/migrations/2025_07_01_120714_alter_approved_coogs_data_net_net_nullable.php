// database/migrations/YYYY_MM_DD_HHMMSS_alter_approved_coogs_data_net_net_nullable.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterApprovedCoogsDataNetNetNullable extends Migration
{
    public function up()
    {
        Schema::table('approved_coogs_data', function (Blueprint $table) {
            $table->double('net_net')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('approved_coogs_data', function (Blueprint $table) {
            $table->double('net_net')->nullable(false)->change();
        });
    }
}
