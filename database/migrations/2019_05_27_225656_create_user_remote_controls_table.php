<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRemoteControlsTable extends Migration
{
    /**
     * The name of the database table to use.
     *
     * @var string
     */
    protected $table;

    /**
     * Construct a new migration.
     */
    public function __construct()
    {
        $config = \config('remote-control.database', [
            'table' => 'user_remote_controls',
            'connection' => null,
        ]);

        $this->connection = $config['connection'];
        $this->table = $config['table'];
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id')->nullable()->index();

            $table->string('email')->nullable();
            $table->string('secret');
            $table->string('verification_code');

            $table->timestamp('created_at')->nullable();
            $table->timestamp('used_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
