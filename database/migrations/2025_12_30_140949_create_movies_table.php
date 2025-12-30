    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('movies', function (Blueprint $table) {
                $table->id();
                $table->string('imdb_id')->nullable()->unique()->index();
                $table->string('title');
                $table->smallInteger('year')->nullable();
                $table->string('poster')->nullable();
                $table->json('metadata')->nullable();
                $table->timestamps();

                $table->index(['title', 'year']);
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('movies');
        }
    };
