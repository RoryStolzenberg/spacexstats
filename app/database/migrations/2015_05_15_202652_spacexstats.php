<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use SpaceXStats\Enums\Varchar;

class Spacexstats extends Migration {

    /** Todo:
     * calendar downloads
     * webcast statuses
     * collections
     * types / subtypes
     * notes
     * rss_updates
     * emails_sent
     */

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('astronauts', function(Blueprint $table) {
            $table->increments('astronaut_id');
            $table->string('first_name', Varchar::small);
            $table->string('last_name', Varchar::small);
            $table->string('nationality', Varchar::small);
            $table->date('date_of_birth');
            $table->string('contracted_by', Varchar::small);
        });

        Schema::create('astronaut_flights', function(Blueprint $table) {
            $table->increments('astronaut_flight_id');
            $table->integer('astronaut_id')->unsigned();
            $table->integer('spacecraft_id')->unsigned();
        });

        Schema::create('cores', function(Blueprint $table) {
            $table->increments('core_id');
            $table->string('name', Varchar::small);
            $table->timestamps();
        });

        Schema::create('destinations', function(Blueprint $table) {
            $table->increments('destination_id');
            $table->string('destination', Varchar::small);
        });

        Schema::create('email_subscriptions', function(Blueprint $table) {
            $table->increments('email_subscription_id');
            $table->integer('user_id')->unsigned();
            $table->smallInteger('subscription_type')->unsigned();
        });

        Schema::create('favorites', function(Blueprint $table) {
            $table->increments('favorite_id');
            $table->integer('user_id')->unsigned();
            $table->integer('object_id')->unsigned();
            $table->timestamps();
        });

        Schema::create('landing_sites', function(Blueprint $table) {
            $table->increments('landing_site_id');
            $table->string('name', Varchar::small);
            $table->string('location', Varchar::small)->nullable();
            $table->string('state', Varchar::small)->nullable();
        });

        Schema::create('launch_sites', function(Blueprint $table) {
            $table->increments('launch_site_id');
            $table->string('name', Varchar::small);
            $table->string('location', Varchar::small);
            $table->string('state', Varchar::small);
        });

        Schema::create('missions', function(Blueprint $table) {
            $table->increments('mission_id');
            $table->smallInteger('launch_order_id')->unsigned();
            $table->smallInteger('launch_specificity')->unsigned();
            $table->datetime('launch_exact')->nullable();
            $table->string('launch_approximate', Varchar::small)->nullable();
            $table->string('name', Varchar::small);
            $table->string('slug', Varchar::small);
            $table->enum('type', array('Dragon (ISS)', 'Dragon (Freeflight)', 'Communications Satellite', 'Constellation Mission', 'Military', 'Scientific'));
            $table->string('contractor', Varchar::medium);
            $table->integer('vehicle_id')->unsigned();
            $table->integer('destination_id')->unsigned();
            $table->integer('launch_site_id')->unsigned();
            $table->string('summary', Varchar::summary);
            $table->string('article', Varchar::article)->nullable();
            $table->integer('featured_image')->unsigned()->nullable();
            $table->enum('status', array('Upcoming', 'Complete', 'In Progress'));

            $table->string('upperstage_outcome', Varchar::compact)->nullable();
            $table->enum('upperstage_engine', array('Kestrel', 'Merlin 1C-Vac', 'Merlin 1D-Vac', 'Merlin 1D-Vac Fullthrust'));
            $table->smallInteger('upperstage_seco')->unsigned()->nullable();
            $table->enum('upperstage_status', array('Did not reach orbit', 'Decayed', 'Deorbited', 'Earth Orbit', 'Solar Orbit'))->nullable();
            $table->date('upperstage_decay_date')->nullable();
            $table->smallInteger('upperstage_norad_id')->nullable();
            $table->char('upperstage_intl_designator', 9)->nullable();

            $table->timestamps();
        });

        Schema::create('objects', function(Blueprint $table) {
            $table->increments('object_id');
            $table->integer('user_id')->unsigned();
            $table->integer('mission_id')->unsigned()->nullable();
            $table->smallInteger('type')->unsigned();
            $table->smallInteger('subtype')->unsigned()->nullable();
            $table->integer('size')->unsigned();
            $table->string('filetype', Varchar::compact);
            $table->string('mimetype', Varchar::compact);
            $table->string('original_name', Varchar::compact);
            $table->string('title', Varchar::compact);
            $table->string('filename', Varchar::small);
            $table->smallInteger('dimension_width')->nullable();
            $table->smallInteger('dimension_height')->nullable();
            $table->double('coord_lat', 8, 6)->nullable();
            $table->double('coord_lng', 9, 6)->nullable();
            $table->string('camera_manufacturer', Varchar::compact)->nullable();
            $table->string('camera_model', Varchar::compact)->nullable();

            /* Twitter related */
            $table->string('tweet_id', Varchar::small)->nullable();
            $table->datetime('tweet_created_at')->nullable();
            $table->string('tweet_user_screen_name', Varchar::small)->nullable();
            $table->string('tweet_user_name', Varchar::small)->nullable();
            $table->string('tweet_text', Varchar::compact)->nullable();
            $table->string('tweet_parent_id', Varchar::small)->nullable();

            // Can this be reconciled to integer values?
            $table->string('exposure', Varchar::small)->nullable();
            $table->string('aperture', Varchar::small)->nullable();
            $table->string('ISO', Varchar::small)->nullable();

            $table->enum('status', array('New', 'Queued', 'Complete', 'Hidden'));
            $table->timestamps();
        });

        Schema::create('orbital_parameters', function(Blueprint $table) {
            $table->increments('orbital_parameter_id');
        });

        Schema::create('payloads', function(Blueprint $table) {
            $table->increments('payload_id');
            $table->integer('mission_id')->unsigned();
            $table->string('name', Varchar::small);
            $table->string('operator', Varchar::small);
            $table->decimal('mass', 6, 1)->nullable();
            $table->boolean('primary');
            $table->string('link', Varchar::small)->nullable();
        });

        Schema::create('payments', function(Blueprint $table) {
            $table->increments('payment_id');
            $table->integer('user_id')->unsigned();
            $table->smallInteger('price')->unsigned();
            $table->timestamps();
        });

        Schema::create('prelaunch_events', function(Blueprint $table) {
            $table->increments('prelaunch_event_id');
            $table->integer('mission_id')->unsigned();
            $table->enum('event', array('Wet Dress Rehearsal', 'Static Fire', 'Launch Change'));
            $table->date('occurred_at');
            $table->datetime('scheduled_launch_exact')->nullable();
            $table->string('scheduled_launch_approx', Varchar::small)->nullable();
            $table->string('summary', Varchar::small)->nullable();
        });

        Schema::create('profiles', function(Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->string('summary', Varchar::large)->nullable();
            $table->string('banner_filename', Varchar::small)->nullable();
            $table->smallInteger('banner_position')->nullable();
            $table->string('reddit_account', Varchar::small)->nullable();
            $table->string('twitter_account', Varchar::small)->nullable();
            $table->integer('favorite_mission')->unsigned()->nullable();
            $table->integer('favorite_mission_patch')->unsigned()->nullable();

            $table->timestamps();
        });

        Schema::create('questions', function(Blueprint $table) {
            $table->increments('question_id');
        });

        Schema::create('roles', function(Blueprint $table) {
            $table->increments('role_id');
            $table->string('name', Varchar::small);
        });

        Schema::create('spacecraft', function(Blueprint $table) {
            $table->increments('spacecraft_id');
            $table->enum('type', array('Dragon 1', 'Dragon 2'));
            $table->string('spacecraft_name', Varchar::small);
        });

        // Pivot table
        Schema::create('spacecraft_flights', function(Blueprint $table) {
            $table->increments('spacecraft_flight_id');
            $table->integer('mission_id')->unsigned();
            $table->integer('spacecraft_id')->unsigned();
            $table->string('flight_name', Varchar::small);
            $table->datetime('return')->nullable();
            $table->enum('return_method', array('Splashdown', 'Landing'))->nullable();
            $table->smallInteger('upmass')->unsigned()->nullable();
            $table->smallInteger('downmass')->unsigned()->nullable();
            $table->datetime('iss_berth')->nullable();
            $table->datetime('iss_unberth')->nullable();
        });

        Schema::create('statistics', function(Blueprint $table) {
            $table->increments('statistic_id');
            $table->smallInteger('order')->unsigned();
            $table->string('type', Varchar::small);
            $table->string('name', Varchar::small);
            $table->string('unit', Varchar::small)->nullable();
            $table->string('description', Varchar::medium);
            $table->enum('display', array('single', 'double', 'count', 'time', 'piechart', 'barchart'));
        });

        Schema::create('users', function(Blueprint $table) {
            $table->increments('user_id');
            $table->integer('role_id')->unsigned();
            $table->string('username', Varchar::small);
            $table->string('firstname', Varchar::small);
            $table->string('email', Varchar::small);
            $table->char('password', 60);
            $table->datetime('subscription_expiry')->nullable();

            $table->datetime('last_login')->nullable();
            $table->char('key', 32);
            $table->rememberToken();
            $table->timestamps();
        });

        // Pivot table
        Schema::create('uses', function(Blueprint $table) {
            $table->increments('use_id');
            $table->integer('mission_id')->unsigned();
            $table->integer('core_id')->unsigned();

            $table->boolean('firststage_landing_legs')->nullable();
            $table->boolean('firststage_grid_fins')->nullable();
            $table->enum('firststage_engine', array('Merlin 1A', 'Merlin 1C', 'Merlin 1D', 'Merlin 1D Fullthrust'));
            $table->integer('landing_site_id')->nullable()->unsigned();
            $table->boolean('firststage_landed')->nullable();
            $table->string('firststage_outcome', Varchar::compact)->nullable();
            $table->smallInteger('firststage_engine_failures')->unsigned()->nullable();
            $table->smallInteger('firststage_meco')->nullable();
            $table->decimal('firststage_landing_coords_lat', 6, 4)->nullable();
            $table->decimal('firststage_landing_coords_lng', 7, 4)->nullable();

            $table->timestamps();
        });

        Schema::create('vehicles', function(Blueprint $table) {
            $table->increments('vehicle_id');
            $table->string('vehicle', Varchar::small);
        });

        // Add foreign keys
        Schema::table('email_subscriptions', function(Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users');
        });

        Schema::table('missions', function(Blueprint $table) {
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles');
            $table->foreign('destination_id')->references('destination_id')->on('destinations');
            $table->foreign('launch_site_id')->references('launch_site_id')->on('launch_sites');
            $table->foreign('featured_image')->references('object_id')->on('objects');
        });

        Schema::table('objects', function(Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('mission_id')->references('mission_id')->on('missions');
        });

        Schema::table('payloads', function(Blueprint $table) {
            $table->foreign('mission_id')->references('mission_id')->on('missions');
        });

        Schema::table('prelaunch_events', function(Blueprint $table) {
            $table->foreign('mission_id')->references('mission_id')->on('missions');
        });

        Schema::table('profiles', function(Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('favorite_mission')->references('mission_id')->on('missions');
            $table->foreign('favorite_mission_patch')->references('mission_id')->on('missions');
        });

        Schema::table('spacecraft_flights', function(Blueprint $table) {
            $table->foreign('mission_id')->references('mission_id')->on('missions');
            $table->foreign('spacecraft_id')->references('spacecraft_id')->on('spacecraft');
        });

        Schema::table('users', function(Blueprint $table) {
            $table->foreign('role_id')->references('role_id')->on('roles')->onUpdate('cascade')->onDelete('restrict');
        });

        Schema::table('uses', function(Blueprint $table) {
            $table->foreign('mission_id')->references('mission_id')->on('missions');
            $table->foreign('core_id')->references('core_id')->on('cores');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

        $tables = array(
            'roles',
            'destinations',
            'launch_sites',
            'landing_sites',
            'vehicles',
            'cores',
            'uses',
            'missions',
            'orbital_parameters',
            'prelaunch_events',
            'spacecraft',
            'spacecraft_flights',
            'astronauts',
            'astronaut_flights',
            'statistics',
            'questions',
            'users',
            'profiles',
            'objects',
            'favorites',
            'payloads',
            'email_subscriptions',
            'payments'
        );

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}

}
