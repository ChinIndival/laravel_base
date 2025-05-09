<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Common\Database\Definition\DatabaseDefs;

/**
 * customer_usersテーブルを作成するマイグレーションクラス。
 */
class CreateCustomerUsersTable extends Migration
{
    /**
     * マイグレーションを実行する。
     * @return void
     * @throws Exception
     */
    public function up(): void
    {
        try {
            Schema::connection(DatabaseDefs::CONNECTION_NAME_MIGRATION)
                ->create('customer_users', function (Blueprint $table) {
                    $table->engine = 'InnoDB';
                    $table->integer('id')->autoIncrement()->startingValue(DatabaseDefs::ID_START_POSITION);
                    $table->string('name', 50);
                    $table->string('name_kana', 100)->nullable();
                    $table->string('tel', 15)->nullable();
                    $table->string('birthday', 10)->nullable();
                    $table->string('address', 100)->nullable();
                    $table->string('email', 50)->nullable();
                    $table->string('password', 50)->nullable();
                    $table->rememberToken();
                    $table->string('gender', 50)->nullable();
                    $table->string('avatar', 50)->nullable();
                    $table->timestamp('email_verified_at')->nullable();
                    $table->timestamp('last_login_at')->nullable();
                    $table->timestamps();
                    $table->softDeletes();
                });

            DB::connection(DatabaseDefs::CONNECTION_NAME_MIGRATION)
                ->statement('ALTER TABLE `customer_users` ROW_FORMAT=DYNAMIC;');
            DB::connection(DatabaseDefs::CONNECTION_NAME_MIGRATION)
                ->statement('ALTER TABLE `customer_users` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;');
        }
        catch (PDOException $e) {
            $this->down();
            throw $e;
        }
    }

    /**
     * マイグレーションをロールバックする。
     * @return void
     */
    public function down(): void
    {
        Schema::connection(DatabaseDefs::CONNECTION_NAME_MIGRATION)
            ->dropIfExists('customer_users');
    }
}
