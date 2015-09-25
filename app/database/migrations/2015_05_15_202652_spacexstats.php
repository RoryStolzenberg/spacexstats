<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use SpaceXStats\Enums\Varchar;

class Spacexstats extends Migration {

    /** Todo:
     * calendar downloads
     * webcast statuses
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
            $table->string('first_name', Varchar::tiny);
            $table->string('last_name', Varchar::tiny);
            $table->enum('gender', array('Male', 'Female'));
            $table->boolean('deceased');
            $table->string('nationality', Varchar::tiny);
            $table->date('date_of_birth');  // Nonoptional values
            $table->string('contracted_by', Varchar::tiny);
        });

        // Pivot table
        Schema::create('astronauts_flights_pivot', function(Blueprint $table) {
            $table->increments('astronaut_flight_id');
            $table->integer('astronaut_id')->unsigned();
            $table->integer('spacecraft_flight_id')->unsigned();
        });


        Schema::create('awards', function(Blueprint $table) {
            $table->increments('award_id');
            $table->integer('object_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->enum('type', array('Created', 'Edited'));
            $table->smallInteger('value')->unsigned();

            $table->timestamps();
        });

        Schema::create('comments', function(Blueprint $table) {
            $table->increments('comment_id');
            $table->integer('object_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('comment', Varchar::large);
            $table->integer('parent')->unsigned();

            $table->boolean('isHidden');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('collections', function(Blueprint $table) {
            $table->increments('collection_id');
            $table->integer('user_id')->unsigned();
            $table->integer('mission_id')->unsigned()->nullable();

            $table->string('title', Varchar::small);
            $table->string('summary', Varchar::large);

            $table->timestamps();
        });

        // Pivot table
        Schema::create('collections_objects_pivot', function(Blueprint $table) {
            $table->increments('collection_object_id');
            $table->integer('collection_id')->unsigned();
            $table->integer('object_id')->unsigned();
            $table->timestamps();
        });

        Schema::create('dataviews', function(Blueprint $table) {
            $table->increments('dataview_id');
            $table->string('name', Varchar::small);
            $table->string('column_titles', Varchar::medium);
            $table->string('query', Varchar::medium);
            $table->string('summary', Varchar::medium);
            $table->integer('banner_image')->unsigned();
        });

        Schema::create('destinations', function(Blueprint $table) {
            $table->increments('destination_id');
            $table->string('destination', Varchar::tiny);
        });

        Schema::create('downloads', function(Blueprint $table) {
            $table->increments('download_id');
            $table->integer('user_id')->unsigned();
            $table->integer('object_id')->unsigned();
            $table->timestamps();
        });

        Schema::create('emails', function(Blueprint $table) {
            $table->increments('email_id');
            $table->integer('notification_id')->unsigned()->nullable();
            $table->string('subject', Varchar::small)->nullable();
            $table->string('body', Varchar::large)->nullable();
            $table->enum('status', array('Held', 'Queued', 'Sent'));
            $table->datetime('sent_at')->nullable(); // Nonoptional values
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
            $table->string('name', Varchar::tiny);
            $table->string('location', Varchar::tiny)->nullable();
            $table->string('state', Varchar::tiny)->nullable();
            $table->double('coord_lat', 8, 6)->nullable();
            $table->double('coord_lng', 9, 6)->nullable();
            $table->enum('type', array('Launch Site', 'Landing Site', 'ASDS', 'Facility'));
            $table->enum('status', array('No longer used', 'Active', 'Planned'));
        });

        Schema::create('messages', function(Blueprint $table) {
            $table->increments('message_id');
            $table->integer('user_id')->unsigned();
            $table->string('message', Varchar::medium);
            $table->boolean('hasBeenRead');
            $table->timestamps();
        });

        Schema::create('missions', function(Blueprint $table) {
            $table->increments('mission_id');
            $table->integer('mission_type_id')->unsigned();
            $table->smallInteger('launch_order_id')->unsigned();
            $table->smallInteger('launch_specificity')->unsigned();
            $table->datetime('launch_exact')->nullable(); // Nonoptional Values
            $table->string('launch_approximate', Varchar::tiny)->nullable();
            $table->string('name', Varchar::tiny);
            $table->string('slug', Varchar::tiny);
            $table->string('contractor', Varchar::compact);
            $table->integer('vehicle_id')->unsigned();
            $table->integer('destination_id')->unsigned();
            $table->integer('launch_site_id')->unsigned();
            $table->enum('launch_illumination', array('Day', 'Night', 'Twilight'))->nullable();
            $table->string('summary', Varchar::compact);
            $table->string('article', Varchar::large)->nullable();

            // States
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
            $table->integer('featured_image')->unsigned()->nullable();

            // Links to other pages
            $table->string('reddit_discussion', Varchar::small)->nullable();
            $table->string('flight_club', Varchar::small)->nullable();

            $table->timestamps();
        });

        Schema::create('mission_types', function(Blueprint $table) {
            $table->increments('mission_type_id');
            $table->string('name', Varchar::tiny);
            $table->string('icon', Varchar::small);
        });

        Schema::create('notes', function(Blueprint $table) {
            $table->increments('note_id');
            $table->integer('user_id')->unsigned();
            $table->integer('object_id')->unsigned();
            $table->string('note', Varchar::medium);

            $table->timestamps();
        });

        Schema::create('notifications', function(Blueprint $table) {
            $table->increments('notification_id');
            $table->integer('user_id')->unsigned();
            $table->integer('notification_type_id')->unsigned();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('notification_types', function(Blueprint $table) {
            $table->increments('notification_type_id');
            $table->string('name', Varchar::tiny);
        });

        Schema::create('objects', function(Blueprint $table) {
            $table->increments('object_id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('mission_id')->unsigned()->nullable();
            $table->smallInteger('type')->unsigned();
            $table->smallInteger('subtype')->unsigned()->nullable();
            $table->integer('size')->unsigned();
            $table->string('filetype', Varchar::small)->nullable();
            $table->string('mimetype', Varchar::small)->nullable();
            $table->string('original_name', Varchar::small)->nullable();
            $table->string('title', Varchar::small);
            $table->string('filename', Varchar::tiny)->nullable();
            $table->string('thumb_filename', Varchar::tiny)->nullable();
            $table->string('local_file', Varchar::small)->nullable();
            $table->char('cryptographic_hash', 64)->nullable();
            $table->string('perceptual_hash')->nullable();

            $table->smallInteger('dimension_width')->nullable();
            $table->smallInteger('dimension_height')->nullable();
            $table->smallInteger('length')->nullable();

            // Mission control related properties
            $table->string('summary', Varchar::large);
            $table->string('author', Varchar::tiny)->nullable();
            $table->string('attribution', Varchar::compact)->nullable();
            $table->date('originated_at')->nullable(); // Optional day & month

            // Twitter-related properties
            $table->string('tweet_id', Varchar::tiny)->nullable();
            $table->datetime('tweet_created_at')->nullable(); // Optional second, minute, hour, day, month
            $table->string('tweet_text', Varchar::small)->nullable();
            $table->string('tweet_parent_id', Varchar::tiny)->nullable();
            $table->integer('tweeter_id')->unsigned()->nullable();

            // Image-related properties
            $table->string('exposure', Varchar::tiny)->nullable();
            $table->string('aperture', Varchar::tiny)->nullable();
            $table->smallInteger('ISO')->nullable();
            $table->double('coord_lat', 8, 6)->nullable();
            $table->double('coord_lng', 9, 6)->nullable();
            $table->string('camera_manufacturer', Varchar::small)->nullable();
            $table->string('camera_model', Varchar::small)->nullable();

            // Post-related properties
            $table->integer('publisher_id')->unsigned()->nullable();
            $table->mediumText('article')->nullable();

            // Reddit-related properties
            $table->string('reddit_comment_id', Varchar::tiny)->nullable();
            $table->string('reddit_parent_id', Varchar::tiny)->nullable();
            $table->string('reddit_subreddit', Varchar::tiny)->nullable();

            // Third-party-related properties
            $table->string('external_url', Varchar::small)->nullable();

            $table->enum('status', array('New', 'Queued', 'Published'));
            $table->enum('visibility', array('Default', 'Public', 'Hidden'));
            $table->boolean('anonymous');
            $table->datetime('actioned_at')->nullable(); // Nonoptional values
            $table->timestamps();
        });

        Schema::create('object_histories', function(Blueprint $table) {
            $table->increments('object_history_id');
            $table->integer('object_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->text('object');
            $table->string('changelog', Varchar::xlarge)->nullable();
            $table->timestamps();
        });

        Schema::create('orbital_parameters', function(Blueprint $table) {
            $table->increments('orbital_parameter_id');
        });

        Schema::create('parts', function(Blueprint $table) {
            $table->increments('part_id');
            $table->string('name', Varchar::tiny);
            $table->enum('type', array('Upper Stage', 'First Stage', 'Booster'));
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
            $table->tinyInteger('firststage_engine_failures')->unsigned()->nullable();
            $table->tinyInteger('firststage_meco')->unsigned()->nullable();
            $table->decimal('firststage_landing_coords_lat', 6, 4)->nullable();
            $table->decimal('firststage_landing_coords_lng', 7, 4)->nullable();
            $table->enum('baseplate_color', array('White', 'Black'))->nullable();

            // Second stage stuff
            $table->enum('upperstage_engine', array('Kestrel', 'Merlin 1C-Vac', 'Merlin 1D-Vac', 'Merlin 1D-Vac Fullthrust'))->nullable();
            $table->smallInteger('upperstage_seco')->unsigned()->nullable();
            $table->enum('upperstage_status', array('Did not reach orbit', 'Decayed', 'Deorbited', 'Earth Orbit', 'Solar Orbit'))->nullable();
            $table->date('upperstage_decay_date')->nullable(); // Nonoptional Values
            $table->smallInteger('upperstage_norad_id')->unsigned()->nullable();
            $table->char('upperstage_intl_designator', 9)->nullable();

            $table->boolean('landed')->nullable();
            $table->string('note', Varchar::small)->nullable();

            $table->timestamps();
        });

        Schema::create('payloads', function(Blueprint $table) {
            $table->increments('payload_id');
            $table->integer('mission_id')->unsigned();
            $table->string('name', Varchar::tiny);
            $table->string('operator', Varchar::small);
            $table->decimal('mass', 6, 1)->nullable();
            $table->boolean('primary');
            $table->string('link', Varchar::small)->nullable();

            $table->timestamps();
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
            $table->enum('event', array('Announcement', 'Wet Dress Rehearsal', 'Static Fire', 'Launch Change'));
            $table->date('occurred_at'); // Nonoptional values
            $table->datetime('scheduled_launch_exact')->nullable(); // Nonoptional values
            $table->string('scheduled_launch_approximate', Varchar::tiny)->nullable();
            $table->string('summary', Varchar::tiny)->nullable();
        });

        Schema::create('profiles', function(Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->string('summary', Varchar::medium)->nullable();
            $table->string('banner_filename', Varchar::tiny)->nullable();
            $table->smallInteger('banner_position')->nullable();
            $table->string('reddit_account', Varchar::tiny)->nullable();
            $table->string('twitter_account', Varchar::tiny)->nullable();
            $table->integer('favorite_mission')->unsigned()->nullable();
            $table->integer('favorite_mission_patch')->unsigned()->nullable();
            $table->string('favorite_quote', Varchar::medium)->nullable();

            $table->timestamps();
        });

        Schema::create('publishers', function(Blueprint $table) {
            $table->increments('publisher_id');
            $table->string('name', Varchar::tiny);
            $table->string('icon', Varchar::small)->nullable();
        });

        Schema::create('questions', function(Blueprint $table) {
            $table->increments('question_id');
        });

        Schema::create('roles', function(Blueprint $table) {
            $table->increments('role_id');
            $table->string('name', Varchar::tiny);
        });

        Schema::create('smses', function(Blueprint $table) {
            $table->increments('sms_id');
            $table->integer('user_id')->unsigned();
            $table->integer('notification_id')->unsigned();
            $table->string('message', Varchar::compact)->nullable();
            $table->timestamps();
        });

        Schema::create('spacecraft', function(Blueprint $table) {
            $table->increments('spacecraft_id');
            $table->string('name', Varchar::tiny);
            $table->enum('type', array('Dragon 1', 'Dragon 2'));
        });

        // Pivot table
        Schema::create('spacecraft_flights_pivot', function(Blueprint $table) {
            $table->increments('spacecraft_flight_id');
            $table->integer('mission_id')->unsigned();
            $table->integer('spacecraft_id')->unsigned();
            $table->string('flight_name', Varchar::tiny);
            $table->datetime('end_of_mission')->nullable(); // Nonoptional Values
            $table->enum('return_method', array('Splashdown', 'Landing', 'Did Not Return'))->nullable();
            $table->smallInteger('upmass')->unsigned()->nullable();
            $table->smallInteger('downmass')->unsigned()->nullable();
            $table->datetime('iss_berth')->nullable(); // Nonoptional Values
            $table->datetime('iss_unberth')->nullable(); // Nonoptional Values
        });

        Schema::create('statistics', function(Blueprint $table) {
            $table->increments('statistic_id');
            $table->smallInteger('order')->unsigned();
            $table->string('type', Varchar::tiny);
            $table->string('name', Varchar::tiny);
            $table->string('unit', Varchar::tiny)->nullable();
            $table->string('description', Varchar::compact);
            $table->enum('display', array('single', 'double', 'count', 'time', 'piechart', 'barchart'));
        });

        Schema::create('taggables_pivot', function(Blueprint $table) {
            $table->increments('taggable_pivot_id');
            $table->integer('tag_id')->unsigned();
            $table->integer('taggable_id')->unsigned();
            $table->string('taggable_type', Varchar::tiny);
            $table->timestamps();
        });

        Schema::create('tags', function(Blueprint $table) {
            $table->increments('tag_id');
            $table->string('name', Varchar::tiny);
            $table->string('description', Varchar::compact)->nullable();
            $table->timestamps();
        });

        Schema::create('telemetries', function(Blueprint $table) {
            $table->increments('telemetry_id');
            $table->integer('mission_id')->unsigned();
            $table->smallInteger('timestamp')->unsigned();
            $table->string('readout', Varchar::small)->nullable();
            $table->smallInteger('altitude')->unsigned();
            $table->smallInteger('velocity')->unsigned();
            $table->smallInteger('downrange')->unsigned();
            $table->timestamps();
        });

        Schema::create('tweeters', function(Blueprint $table) {
            $table->increments('tweeter_id');
            $table->string('user_profile_image_url', Varchar::small)->nullable();
            $table->string('user_screen_name', Varchar::tiny)->nullable();
            $table->string('user_name', Varchar::tiny)->nullable();
        });

        Schema::create('users', function(Blueprint $table) {
            $table->increments('user_id');
            $table->integer('role_id')->unsigned();
            $table->string('username', Varchar::tiny);
            $table->string('firstname', Varchar::tiny);
            $table->string('email', Varchar::tiny);

            $table->string('mobile', Varchar::tiny)->nullable();
            $table->string('mobile_national_format', Varchar::tiny)->nullable();
            $table->string('mobile_country_code', Varchar::tiny)->nullable();
            $table->string('mobile_carrier', Varchar::small)->nullable();

            $table->char('password', 60);
            $table->datetime('subscription_expiry')->nullable(); // Nonoptional Values

            // Specific roles
            $table->boolean('launchCentralFlag');
            $table->boolean('articleWriterFlag');
            $table->boolean('canSeeHiddenItemsFlag');
            $table->boolean('bannedFlag');

            $table->datetime('last_login')->nullable(); // Nonoptional Values
            $table->char('key', 32);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('vehicles', function(Blueprint $table) {
            $table->increments('vehicle_id');
            $table->string('vehicle', Varchar::tiny);
        });

        // Add foreign keys
        Schema::table('astronauts_flights_pivot', function(Blueprint $table) {
            $table->foreign('astronaut_id')->references('astronaut_id')->on('astronauts');
            $table->foreign('spacecraft_flight_id')->references('spacecraft_flight_id')->on('spacecraft_flights_pivot');
        });

        Schema::table('collections', function(Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('mission_id')->references('mission_id')->on('missions');
        });

        Schema::table('collections_objects_pivot', function(Blueprint $table) {
            $table->foreign('collection_id')->references('collection_id')->on('collections');
            $table->foreign('object_id')->references('object_id')->on('objects');
        });

        Schema::table('dataviews', function(Blueprint $table) {
            $table->foreign('banner_image')->references('object_id')->on('objects');
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
            $table->foreign('featured_image')->references('object_id')->on('objects');
        });

        Schema::table('notes', function(Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('object_id')->references('object_id')->on('objects');
        });

        Schema::table('objects', function(Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');
            $table->foreign('mission_id')->references('mission_id')->on('missions');

            $table->foreign('publisher_id')->references('publisher_id')->on('publishers');
            $table->foreign('tweeter_id')->references('tweeter_id')->on('tweeters');
        });

        Schema::table('taggables_pivot', function(Blueprint $table) {
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
