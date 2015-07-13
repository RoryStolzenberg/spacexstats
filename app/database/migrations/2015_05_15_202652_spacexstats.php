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
     * rss_updates
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

        // Pivot table
        Schema::create('astronauts_flights_pivot', function(Blueprint $table) {
            $table->increments('astronaut_flight_id');
            $table->integer('astronaut_id')->unsigned();
            $table->integer('spacecraft_flight_id')->unsigned();
        });

        /*Schema::create('collections', function(Blueprint $table) {
            $table->increments('collection_id');
            $table->
        });

        // Pivot table
        Schema::create('collections_objects_pivot', function(Blueprint $table) {

        });*/

        Schema::create('destinations', function(Blueprint $table) {
            $table->increments('destination_id');
            $table->string('destination', Varchar::small);
        });

        Schema::create('downloads', function(Blueprint $table) {
            $table->increments('download_id');
            $table->integer('user_id')->unsigned();
            $table->integer('object_id')->unsigned();
            $table->timestamps();
        });

        Schema::create('emails', function(Blueprint $table) {
            $table->increments('email_id');
            $table->integer('notification_id')->unsigned();
            $table->string('subject', Varchar::compact)->nullable();
            $table->string('body', Varchar::xlarge)->nullable();
            $table->enum('status', array('Held', 'Queued', 'Sent'));
            $table->datetime('sent_at')->nullable();
            $table->timestamps();
        });

        Schema::create('favorites', function(Blueprint $table) {
            $table->increments('favorite_id');
            $table->integer('user_id')->unsigned();
            $table->integer('object_id')->unsigned();
            $table->timestamps();
        });

        Schema::create('locations', function(Blueprint $table) {
            $table->increments('location_id');
            $table->string('name', Varchar::small);
            $table->string('location', Varchar::small)->nullable();
            $table->string('state', Varchar::small)->nullable();
            $table->double('coord_lat', 8, 6)->nullable();
            $table->double('coord_lng', 9, 6)->nullable();
            $table->enum('type', array('Launch Site', 'Landing Site', 'ASDS', 'Facility'));
            $table->enum('status', array('No longer used', 'Active', 'Planned'));
        });

        Schema::create('missions', function(Blueprint $table) {
            $table->increments('mission_id');
            $table->integer('mission_type_id')->unsigned();
            $table->smallInteger('launch_order_id')->unsigned();
            $table->smallInteger('launch_specificity')->unsigned();
            $table->datetime('launch_exact')->nullable();
            $table->string('launch_approximate', Varchar::small)->nullable();
            $table->string('name', Varchar::small);
            $table->string('slug', Varchar::small);
            $table->string('contractor', Varchar::medium);
            $table->integer('vehicle_id')->unsigned();
            $table->integer('destination_id')->unsigned();
            $table->integer('launch_site_id')->unsigned();
            $table->string('summary', Varchar::medium);
            $table->string('article', Varchar::xlarge)->nullable();
            $table->enum('status', array('Upcoming', 'Complete', 'In Progress'));
            $table->enum('outcome', array('Failure', 'Success'))->nullable();

            $table->boolean('fairings_recovered')->nullable();

            // Relations to rows on the objects table
            $table->integer('launch_video')->unsigned()->nullable();
            $table->integer('mission_patch')->unsigned()->nullable();
            $table->integer('press_kit')->unsigned()->nullable();
            $table->integer('cargo_manifest')->unsigned()->nullable();
            $table->integer('prelaunch_press_conference')->unsigned()->nullable();
            $table->integer('postlaunch_press_conference')->unsigned()->nullable();
            $table->integer('reddit_discussion')->unsigned()->nullable();
            $table->integer('featured_image')->unsigned()->nullable();

            $table->timestamps();
        });

        Schema::create('mission_types', function(Blueprint $table) {
            $table->increments('mission_type_id');
            $table->string('name', Varchar::small);
            $table->string('icon', Varchar::compact);
        });

        Schema::create('notes', function(Blueprint $table) {
            $table->increments('note_id');
            $table->integer('user_id')->unsigned();
            $table->integer('object_id')->unsigned();
            $table->string('note', Varchar::large);

            $table->timestamps();
        });

        Schema::create('notifications', function(Blueprint $table) {
            $table->increments('notification_id');
            $table->integer('user_id')->unsigned();
            $table->integer('notification_type_id')->unsigned();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('objects', function(Blueprint $table) {
            $table->increments('object_id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('mission_id')->unsigned()->nullable();
            $table->smallInteger('type')->unsigned();
            $table->smallInteger('subtype')->unsigned()->nullable();
            $table->integer('size')->unsigned();
            $table->string('filetype', Varchar::compact);
            $table->string('mimetype', Varchar::compact);
            $table->string('original_name', Varchar::compact);
            $table->string('title', Varchar::compact);
            $table->string('filename', Varchar::small);
            $table->string('thumb_large', Varchar::small);
            $table->string('thumb_small', Varchar::small);
            $table->char('cryptographic_hash', 64)->nullable();
            $table->string('perceptual_hash')->nullable();

            $table->smallInteger('dimension_width')->nullable();
            $table->smallInteger('dimension_height')->nullable();
            $table->smallInteger('length')->nullable();

            // Mission control related properties
            $table->string('summary', Varchar::large);
            $table->string('author', Varchar::small)->nullable();
            $table->string('attribution', Varchar::medium)->nullable();
            $table->date('originated_at')->nullable();

            // Twitter-related properties
            $table->string('tweet_id', Varchar::small)->nullable();
            $table->datetime('tweet_created_at')->nullable();
            $table->string('tweet_user_screen_name', Varchar::small)->nullable();
            $table->string('tweet_user_name', Varchar::small)->nullable();
            $table->string('tweet_text', Varchar::compact)->nullable();
            $table->string('tweet_parent_id', Varchar::small)->nullable();

            // Image-related properties
            $table->string('exposure', Varchar::small)->nullable();
            $table->string('aperture', Varchar::small)->nullable();
            $table->smallInteger('ISO')->nullable();
            $table->double('coord_lat', 8, 6)->nullable();
            $table->double('coord_lng', 9, 6)->nullable();
            $table->string('camera_manufacturer', Varchar::compact)->nullable();
            $table->string('camera_model', Varchar::compact)->nullable();

            // Third-party-related properties
            $table->string('external_url', Varchar::compact)->nullable();

            $table->enum('status', array('New', 'Queued', 'Published', 'Deleted'));
            $table->enum('visibility', array('Default', 'Public', 'Hidden'));
            $table->datetime('actioned_at')->nullable();
            $table->boolean('anonymous');
            $table->timestamps();
        });

        Schema::create('objects_tags_pivot', function(Blueprint $table) {
            $table->increments('objects_tags_id');
            $table->integer('object_id')->unsigned();
            $table->integer('tag_id')->unsigned();
        });

        Schema::create('orbital_parameters', function(Blueprint $table) {
            $table->increments('orbital_parameter_id');
        });

        Schema::create('parts', function(Blueprint $table) {
            $table->increments('part_id');
            $table->string('name', Varchar::small);
            $table->enum('type', array('Upper Stage', 'First Stage', 'First Stage Booster'));
            $table->timestamps();
        });

        // Pivot table
        Schema::create('part_flights_pivot', function(Blueprint $table) {
            $table->increments('part_flight_id');
            $table->integer('mission_id')->unsigned();
            $table->integer('part_id')->unsigned();

            // First stage & booster stuff
            $table->boolean('firststage_landing_legs')->nullable();
            $table->boolean('firststage_grid_fins')->nullable();
            $table->enum('firststage_engine', array('Merlin 1A', 'Merlin 1C', 'Merlin 1D', 'Merlin 1D Fullthrust'))->nullable();
            $table->integer('landing_site_id')->nullable()->unsigned();
            $table->boolean('firststage_landed')->nullable();
            $table->string('firststage_outcome', Varchar::compact)->nullable();
            $table->tinyInteger('firststage_engine_failures')->unsigned()->nullable();
            $table->tinyInteger('firststage_meco')->unsigned()->nullable();
            $table->decimal('firststage_landing_coords_lat', 6, 4)->nullable();
            $table->decimal('firststage_landing_coords_lng', 7, 4)->nullable();
            $table->enum('baseplate_color', array('White', 'Black'))->nullable();

            // Second stage stuff
            $table->string('upperstage_note', Varchar::compact)->nullable();
            $table->enum('upperstage_engine', array('Kestrel', 'Merlin 1C-Vac', 'Merlin 1D-Vac', 'Merlin 1D-Vac Fullthrust'))->nullable();
            $table->smallInteger('upperstage_seco')->unsigned()->nullable();
            $table->enum('upperstage_status', array('Did not reach orbit', 'Decayed', 'Deorbited', 'Earth Orbit', 'Solar Orbit'))->nullable();
            $table->date('upperstage_decay_date')->nullable();
            $table->smallInteger('upperstage_norad_id')->unsigned()->nullable();
            $table->char('upperstage_intl_designator', 9)->nullable();

            $table->timestamps();
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
            $table->string('favorite_quote', Varchar::large)->nullable();

            $table->timestamps();
        });

        Schema::create('questions', function(Blueprint $table) {
            $table->increments('question_id');
        });

        Schema::create('roles', function(Blueprint $table) {
            $table->increments('role_id');
            $table->string('name', Varchar::small);
        });

        Schema::create('smses', function(Blueprint $table) {
            $table->increments('sms_id');
            $table->integer('user_id')->unsigned();
            $table->integer('notification_id')->unsigned();
            $table->string('content', Varchar::medium)->nullable();
            $table->timestamps();
        });

        Schema::create('spacecraft', function(Blueprint $table) {
            $table->increments('spacecraft_id');
            $table->enum('type', array('Dragon 1', 'Dragon 2'));
            $table->string('spacecraft_name', Varchar::small);
        });

        // Pivot table
        Schema::create('spacecraft_flights_pivot', function(Blueprint $table) {
            $table->increments('spacecraft_flight_id');
            $table->integer('mission_id')->unsigned();
            $table->integer('spacecraft_id')->unsigned();
            $table->string('flight_name', Varchar::small);
            $table->datetime('end_of_mission')->nullable();
            $table->enum('return_method', array('Splashdown', 'Landing', 'Destroyed'))->nullable();
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

        Schema::create('notification_types', function(Blueprint $table) {
            $table->increments('notification_type_id');
            $table->string('name', Varchar::small);
        });


        Schema::create('tags', function(Blueprint $table) {
            $table->increments('tag_id');
            $table->string('name', Varchar::small);
            $table->string('description', Varchar::medium)->nullable();
            $table->timestamps();
        });

        Schema::create('users', function(Blueprint $table) {
            $table->increments('user_id');
            $table->integer('role_id')->unsigned();
            $table->string('username', Varchar::small);
            $table->string('firstname', Varchar::small);
            $table->string('email', Varchar::small);
            $table->string('mobile', Varchar::small)->nullable();
            $table->string('mobile_national_format', Varchar::small)->nullable();
            $table->string('mobile_country_code', Varchar::small)->nullable();
            $table->string('mobile_network', Varchar::compact)->nullable();

            $table->char('password', 60);
            $table->datetime('subscription_expiry')->nullable();

            $table->datetime('last_login')->nullable();
            $table->char('key', 32);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('vehicles', function(Blueprint $table) {
            $table->increments('vehicle_id');
            $table->string('vehicle', Varchar::small);
        });

        // Add foreign keys
        Schema::table('astronauts_flights_pivot', function(Blueprint $table) {
            $table->foreign('astronaut_id')->references('astronaut_id')->on('astronauts');
            $table->foreign('spacecraft_flight_id')->references('spacecraft_flight_id')->on('spacecraft_flights_pivot');
        });

        Schema::table('emails', function(Blueprint $table) {
            $table->foreign('notification_id')->references('notification_id')->on('notifications');
        });

        Schema::table('notifications', function(Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('notification_type_id')->references('notification_type_id')->on('notification_types');
        });

        Schema::table('missions', function(Blueprint $table) {
            $table->foreign('mission_type_id')->references('mission_type_id')->on('mission_types');
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles');
            $table->foreign('destination_id')->references('destination_id')->on('destinations');
            $table->foreign('launch_site_id')->references('location_id')->on('locations');

            $table->foreign('launch_video')->references('object_id')->on('objects');
            $table->foreign('mission_patch')->references('object_id')->on('objects');
            $table->foreign('press_kit')->references('object_id')->on('objects');
            $table->foreign('cargo_manifest')->references('object_id')->on('objects');
            $table->foreign('prelaunch_press_conference')->references('object_id')->on('objects');
            $table->foreign('postlaunch_press_conference')->references('object_id')->on('objects');
            $table->foreign('reddit_discussion')->references('object_id')->on('objects');
            $table->foreign('featured_image')->references('object_id')->on('objects');
        });

        Schema::table('notes', function(Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('object_id')->references('object_id')->on('objects');
        });

        Schema::table('objects', function(Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');
            $table->foreign('mission_id')->references('mission_id')->on('missions');
        });

        Schema::table('objects_tags_pivot', function(Blueprint $table) {
            $table->foreign('object_id')->references('object_id')->on('objects')->onDelete('cascade');
            $table->foreign('tag_id')->references('tag_id')->on('tags')->onDelete('cascade');
        });

        Schema::table('part_flights_pivot', function(Blueprint $table) {
            $table->foreign('mission_id')->references('mission_id')->on('missions');
            $table->foreign('landing_site_id')->references('location_id')->on('locations');
            $table->foreign('part_id')->references('part_id')->on('parts');
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

        Schema::table('smses', function(Blueprint $table) {
            $table->foreign('notification_id')->references('notification_id')->on('notifications');
        });

        Schema::table('spacecraft_flights_pivot', function(Blueprint $table) {
            $table->foreign('mission_id')->references('mission_id')->on('missions');
            $table->foreign('spacecraft_id')->references('spacecraft_id')->on('spacecraft');
        });

        Schema::table('users', function(Blueprint $table) {
            $table->foreign('role_id')->references('role_id')->on('roles')->onUpdate('cascade')->onDelete('restrict');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        $tables = [];

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        foreach (DB::select('SHOW TABLES') as $k => $v) {
            $tables[] = array_values((array)$v)[0];
        }

        foreach($tables as $table) {
            if ($table != 'migrations') {
                Schema::drop($table);
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
	}

}
