<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Projekt kapcsolattartói
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tinker teszt:
     *   use App\Models\{User,Projects,ProjectMember}
     *   Project::factory()->for(User::find(1))->hasProjectMember(20)->count(20)->create()
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->string('name');
            $table->string('email');
            $table->timestamps();

            $table->unique(['project_id', 'email']);

            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_members');
    }
};
