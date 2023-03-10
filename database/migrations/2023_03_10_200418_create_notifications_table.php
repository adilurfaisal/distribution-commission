<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('title');
            $table->mediumText("body");
            $table->dateTime("send_time")->nullable();
            $table->dateTime("read_time")->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        
        DB::unprepared('
            CREATE TRIGGER `commisions_notification` AFTER INSERT ON `commissions` 
            FOR EACH ROW BEGIN
                INSERT INTO `notifications`(user_id, title, `body`)
                (SELECT new.user_id, "REWARD COMMISSION", CONCAT("Hi ", comuser.name,", You have received ", new.percent,"% of commission amount of $",new.amount," from ",trnuser.name,".") FROM `transactions` trnaction INNER JOIN `users` trnuser ON trnuser.id=trnaction.user_id INNER JOIN `users` comuser ON comuser.id=new.user_id LIMIT 1);
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
