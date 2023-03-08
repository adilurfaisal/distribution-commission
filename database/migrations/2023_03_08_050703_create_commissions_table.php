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
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('trans_id')->nullable();
            $table->double('amount', 10, 2)->default('0.00');
            $table->double('percent', 10, 2)->default('0.00');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('trans_id')->references('id')->on('transactions')->onDelete('cascade');
        });

        
        DB::unprepared('
            CREATE TRIGGER `add_commisions_from_transaction` AFTER INSERT ON `transactions` 
            FOR EACH ROW BEGIN
                IF new.trans_type="add" THEN
                    INSERT INTO `softic_project`.`commissions`(user_id, trans_id, amount, percent, created_at, updated_at)
                    (SELECT u2.id, new.id, ((IF(u2.rule_id=2, 30, IF(u2.rule_id=3, 20, 0))*new.amount)/100), IF(u2.rule_id=2, 30, IF(u2.rule_id=3, 20, 0)), NOW(), NOW() FROM `users` u1 INNER JOIN `users` u2 ON u2.id=u1.ref_id WHERE u1.id=new.user_id AND u2.rule_id IN(2,3));
                
                    INSERT INTO `softic_project`.`commissions`(user_id, trans_id, amount, percent, created_at, updated_at)
                    (SELECT u2.id, new.id, ((10*new.amount)/100), 10, NOW(), NOW() FROM `commissions` com INNER JOIN `users` u1 ON u1.id=com.user_id INNER JOIN `users` u2 ON u2.id=u1.ref_id WHERE com.trans_id=new.id AND u2.rule_id IN(2)); 
    
                END IF;
            END;
        ');
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
