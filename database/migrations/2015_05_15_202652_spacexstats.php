<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use SpaceXStats\Library\Enums\Varchar;

class Spacexstats extends Migration {

    /** Todo:
     * calendar downloads
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
            $table->integer('depth')->unsigned();
            $table->integer('parent')->unsigned()->nullable();

            $table->boolean('isHidden');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('collections', function(Blueprint $table) {
            $table->increments('collection_id');
            $table->integer('creating_user_id')->unsigned()->nullable();
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
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('name', Varchar::small);
            $table->string('column_titles', Varchar::medium);
            $table->string('query', Varchar::medium);
            $table->string('summary', Varchar::medium);
            $table->integer('banner_image')->unsigned()->nullable();
            $table->string('dark_color', Varchar::tiny);
            $table->string('light_color', Varchar::tiny);
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
            $table->integer('user_id')->unsigned()->nullable();
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

        Schema::create('live_updates', function(Blueprint $table) {
            $table->increments('live_update_id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('update', Varchar::large);
            $table->string('update_type', Varchar::tiny)->nullable();
            $table->string('live_event_name', Varchar::small);
            $table->string('timestamp', Varchar::tiny);
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
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
            $table->boolean('launch_paused')->default(false);
            $table->string('name', Varchar::tiny);
            $table->string('slug', Varchar::tiny);
            $table->string('contractor', Varchar::compact);
            $table->integer('vehicle_id')->unsigned();
            $table->integer('destination_id')->unsigned();
            $table->integer('launch_site_id')->unsigned();
            $table->enum('launch_illumination', array('Day', 'Night', 'Twilight'))->nullable();
            $table->string('summary', Varchar::compact);
            $table->string('article', Varchar::xxlarge)->nullable();

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

            // Background position
            $table->string('background_position_x', Varchar::tiny)->nullable();
            $table->string('background_position_y', Varchar::tiny)->nullable();

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
            $table->string('type');
            $table->string('subtype')->nullable();
            $table->integer('size')->unsigned();
            $table->string('filetype', Varchar::small)->nullable();
            $table->string('mimetype', Varchar::small)->nullable();
            $table->string('original_name', Varchar::small)->nullable();
            $table->string('title', Varchar::small);
            $table->char('cryptographic_hash', 64)->nullable();
            $table->string('perceptual_hash')->nullable();

            // Filename and related material
            $table->string('filename', Varchar::tiny)->nullable();
            $table->string('thumb_filename', Varchar::tiny)->nullable();

            $table->boolean('has_temporary_file');
            $table->boolean('has_temporary_thumbs');

            $table->boolean('has_local_file');
            $table->boolean('has_local_thumbs');

            $table->boolean('has_cloud_file');
            $table->boolean('has_cloud_thumbs');

            $table->smallInteger('dimension_width')->nullable();
            $table->smallInteger('dimension_height')->nullable();
            $table->smallInteger('duration')->nullable();
            $table->smallInteger('page_count')->nullable();

            // Mission control related properties
            $table->string('summary', Varchar::large);
            $table->string('author', Varchar::tiny)->nullable();
            $table->string('attribution', Varchar::compact)->nullable();
            $table->datetime('originated_at');
            $table->string('originated_at_specificity');

            // Twitter-related properties
            $table->string('tweet_id', Varchar::tiny)->nullable();
            $table->string('tweet_text', 140)->nullable();
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

            // Article-related properties
            $table->integer('publisher_id')->unsigned()->nullable();
            $table->mediumText('article')->nullable();

            // Reddit-related properties
            $table->string('reddit_comment_id', Varchar::tiny)->nullable();
            $table->mediumText('reddit_comment_text')->nullable();
            $table->string('reddit_parent_id', Varchar::tiny)->nullable();
            $table->string('reddit_subreddit', Varchar::tiny)->nullable();

            // NSF-related properties
            $table->mediumText('nsf_comment_text')->nullable();

            // Video-related properties
            $table->string('external_url', Varchar::small)->nullable();

            $table->enum('status', ['New', 'Queued', 'Published']);
            $table->enum('visibility', ['Default', 'Public', 'Hidden']);
            $table->boolean('anonymous')->default(false);
            $table->boolean('original_content')->default(false);
            $table->datetime('actioned_at')->nullable(); // Nonoptional values

            $table->timestamps();
        });

        Schema::create('object_revisions', function(Blueprint $table) {
            $table->increments('object_revision_id');
            $table->integer('object_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->text('object');
            $table->string('changelog', Varchar::xlarge)->nullable();
            $table->boolean('did_file_change');
            $table->timestamps();
        });

        Schema::create('orbital_elements', function(Blueprint $table) {
            $table->increments('orbital_element_id');
            $table->integer('part_flight_id')->unsigned();
            $table->string('object_name', 60);
            $table->string('object_type', 11);
            $table->char('classification_type', 1);
            $table->datetime('epoch');
            $table->double('mean_motion', 10, 8);
            $table->double('eccentricity', 8, 7);
            $table->double('inclination', 5, 4);
            $table->double('ra_of_asc_node', 7, 4);
            $table->double('arg_of_pericenter', 7, 4);
            $table->double('mean_anomaly', 7, 4);
            $table->tinyInteger('ephemeris_type')->unsigned();
            $table->smallInteger('element_set_no')->unsigned();
            $table->float('rev_at_epoch');
            $table->double('bstar', 9, 8);
            $table->double('mean_motion_dot', 10, 9);
            $table->double('mean_motion_ddot', 10, 9);
            $table->integer('file')->unsigned();
            $table->string('tle_line0', 62);
            $table->char('tle_line1', 71);
            $table->char('tle_line2', 71);
            $table->double('semimajor_axis', 20, 3);
            $table->double('period', 20, 3)->nullable();
            $table->double('apogee', 20, 3);
            $table->double('perigee', 20, 3);
            $table->timestamps();
        });

        Schema::create('parts', function(Blueprint $table) {
            $table->increments('part_id');
            $table->string('name', Varchar::tiny);
            $table->enum('type', ['Upper Stage', 'First Stage', 'Booster']);
            $table->timestamps();
        });

        // Pivot table
        Schema::create('part_flights_pivot', function(Blueprint $table) {
            $table->increments('part_flight_id');
            $table->integer('mission_id')->unsigned();
            $table->integer('part_id')->unsigned();

            // First stage & booster stuff
            $table->boolean('firststage_landing_legs')->nullable()->default(false);
            $table->boolean('firststage_grid_fins')->nullable()->default(false);
            $table->enum('firststage_engine', ['Merlin 1A', 'Merlin 1C-F1', 'Merlin 1C-F9', 'Merlin 1D', 'Merlin 1D Fullthrust'])->nullable();
            $table->integer('landing_site_id')->nullable()->unsigned();
            $table->tinyInteger('firststage_engine_failures')->unsigned()->default(0);
            $table->tinyInteger('firststage_meco')->unsigned()->nullable();
            $table->decimal('firststage_landing_coords_lat', 6, 4)->nullable();
            $table->decimal('firststage_landing_coords_lng', 7, 4)->nullable();
            $table->enum('baseplate_color', ['White', 'Black'])->nullable();

            // Second stage stuff
            $table->enum('upperstage_engine', ['Kestrel', 'Merlin 1C-Vac', 'Merlin 1D-Vac', 'Merlin 1D-Vac Fullthrust'])->nullable();
            $table->smallInteger('upperstage_seco')->unsigned()->nullable();
            $table->enum('upperstage_status', ['Did not achieve orbit', 'Decayed', 'Deorbited', 'Earth Orbit', 'Solar Orbit'])->nullable();
            $table->datetime('upperstage_decay_date')->nullable(); // Nonoptional Values
            $table->smallInteger('upperstage_norad_id')->unsigned()->nullable();
            $table->char('upperstage_intl_designator', 9)->nullable();

            $table->boolean('landed')->nullable();
            $table->string('note', Varchar::medium)->nullable();

            $table->timestamps();
        });

        Schema::create('password_resets', function(Blueprint $table)
        {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at');
        });

        Schema::create('payloads', function(Blueprint $table) {
            $table->increments('payload_id');
            $table->integer('mission_id')->unsigned();
            $table->string('name', Varchar::tiny);
            $table->string('operator', Varchar::small);
            $table->decimal('mass', 6, 1)->nullable();
            $table->boolean('primary');
            $table->boolean('as_cargo')->default(false);
            $table->string('link', Varchar::small)->nullable();

            $table->timestamps();
        });

        Schema::create('payments', function(Blueprint $table) {
            $table->increments('payment_id');
            $table->integer('user_id')->unsigned();
            $table->smallInteger('price')->unsigned();
            $table->string('plan', Varchar::small);
            $table->datetime('subscription_ends_at');
            $table->timestamps();
        });

        Schema::create('prelaunch_events', function(Blueprint $table) {
            $table->increments('prelaunch_event_id');
            $table->integer('mission_id')->unsigned();
            $table->enum('event', ['Announcement', 'Wet Dress Rehearsal', 'Launch Static Fire', 'Test Static Fire', 'Launch Change']);
            $table->datetime('occurred_at');
            $table->datetime('scheduled_launch_exact')->nullable();
            $table->string('scheduled_launch_approximate', Varchar::tiny)->nullable();
            $table->smallInteger('scheduled_launch_specificity')->unsigned()->nullable();
            $table->string('summary', Varchar::small)->nullable();
            $table->string('supporting_document', Varchar::small)->nullable();
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
            $table->string('description', Varchar::medium);
            $table->string('url', Varchar::small);
            // Create rating system for publishers in the future
        });

        Schema::create('questions', function(Blueprint $table) {
            $table->increments('question_id');
            $table->string('question', Varchar::medium);
            $table->string('answer', Varchar::xlarge);
            $table->string('type', Varchar::tiny);

            $table->timestamps();
        });

        Schema::create('roles', function(Blueprint $table) {
            $table->increments('role_id');
            $table->string('name', Varchar::tiny);
        });

        Schema::create('searches', function(Blueprint $table) {
            $table->increments('search_id');
            $table->string('query', Varchar::large);
            $table->integer('user_id')->unsigned()->nullable();
        });

        Schema::create('smses', function(Blueprint $table) {
            $table->increments('sms_id');
            $table->integer('user_id')->unsigned();
            $table->integer('notification_id')->unsigned()->nullable();
            $table->string('message', Varchar::compact)->nullable();
            $table->timestamps();
        });

        Schema::create('spacecraft', function(Blueprint $table) {
            $table->increments('spacecraft_id');
            $table->string('name', Varchar::tiny);
            $table->enum('type', array('Dragon 1', 'Dragon 1.1', 'Dragon 2'));
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
            $table->enum('display', array('mission', 'single', 'double', 'count', 'interval', 'piechart', 'barchart', 'linechart', 'gesture'));
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

        Schema::create('telemetry', function(Blueprint $table) {
            $table->increments('telemetry_id');
            $table->integer('mission_id')->unsigned();
            $table->smallInteger('timestamp')->unsigned();
            $table->string('readout', Varchar::medium)->nullable();
            $table->integer('altitude')->unsigned()->nullable();
            $table->smallInteger('velocity')->unsigned()->nullable();
            $table->integer('downrange')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::create('tweeters', function(Blueprint $table) {
            $table->increments('tweeter_id');
            $table->string('user_name', Varchar::tiny)->nullable();
            $table->string('screen_name', Varchar::tiny)->nullable();
            $table->string('description', Varchar::medium)->nullable();
        });

        Schema::create('users', function(Blueprint $table) {
            $table->increments('user_id');
            $table->integer('role_id')->unsigned();
            $table->string('username', Varchar::tiny)->unique();
            $table->string('firstname', Varchar::tiny);
            $table->string('email', Varchar::tiny)->unique();

            $table->string('mobile', Varchar::tiny)->nullable();
            $table->string('mobile_national_format', Varchar::tiny)->nullable();
            $table->string('mobile_country_code', Varchar::tiny)->nullable();
            $table->string('mobile_carrier', Varchar::small)->nullable();

            $table->char('password', 60);

            // Specific roles
            $table->boolean('launch_controller_flag');
            $table->boolean('article_writer_flag'); // Not implemented
            $table->boolean('can_see_hidden_items_flag'); // Not implemented
            $table->boolean('banned_flag'); // Not implemented

            // Payment-related material
            $table->tinyInteger('stripe_active')->default(0);
            $table->string('stripe_id')->nullable();
            $table->string('stripe_subscription')->nullable();
            $table->string('stripe_plan', 100)->nullable();
            $table->string('last_four', 4)->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('subscription_ends_at')->nullable();

            $table->datetime('last_login')->nullable(); // Nonoptional Values
            $table->char('key', 32);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('vehicles', function(Blueprint $table) {
            $table->increments('vehicle_id');
            $table->string('vehicle', Varchar::tiny);
        });

        Schema::create('webcast_statuses', function(Blueprint $table) {
            $table->increments('webcast_status_id');
            $table->integer('viewers');
            $table->timestamps();
        });

        // Add foreign keys
        Schema::table('astronauts_flights_pivot', function(Blueprint $table) {
            $table->foreign('astronaut_id')->references('astronaut_id')->on('astronauts')->onDelete('restrict'); // Restrict deletion of an astronaut if that astronaut has astronaut flights
            $table->foreign('spacecraft_flight_id')->references('spacecraft_flight_id')->on('spacecraft_flights_pivot')->onDelete('cascade'); // When a spacecraft flight is deleted, also delete any referencing astronaut flights
        });

        Schema::table('collections', function(Blueprint $table) {
            $table->foreign('creating_user_id')->references('user_id')->on('users')->onDelete('set null'); // When a user is deleted, set the creating user of the collection to null
            $table->foreign('mission_id')->references('mission_id')->on('missions')->onDelete('cascade'); // When a mission is deleted, also delete any referencing collections
        });

        Schema::table('collections_objects_pivot', function(Blueprint $table) {
            $table->foreign('collection_id')->references('collection_id')->on('collections')->onDelete('cascade'); // When a collection is deleted, also delete any referencing collection_objects
            $table->foreign('object_id')->references('object_id')->on('objects')->onDelete('cascade'); // When an object is deleted, also delete any referencing collection_object
        });

        Schema::table('comments', function(Blueprint $table) {
            $table->foreign('object_id')->references('object_id')->on('objects')->onDelete('cascade');
        });

        Schema::table('dataviews', function(Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');
            $table->foreign('banner_image')->references('object_id')->on('objects')->onDelete('set null'); // When an object is deleted, set the banner image to null
        });

        Schema::table('emails', function(Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null'); // When a user is deleted, set the user id of the email to null
            $table->foreign('notification_id')->references('notification_id')->on('notifications')->onDelete('set null'); // When a notification is deleted, set the notification id of the email to null
        });

        Schema::table('live_updates', function(Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null'); // When a user is deleted, set the user who made the live update to null
        });

        Schema::table('notifications', function(Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade'); // When a user is deleted, also delete any notifications they have
            $table->foreign('notification_type_id')->references('notification_type_id')->on('notification_types')->onDelete('cascade'); // When a notification type is deleted, also delete any notifications
        });

        Schema::table('missions', function(Blueprint $table) {
            $table->foreign('mission_type_id')->references('mission_type_id')->on('mission_types')->onDelete('restrict');
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles')->onDelete('restrict');
            $table->foreign('destination_id')->references('destination_id')->on('destinations')->onDelete('restrict');
            $table->foreign('launch_site_id')->references('location_id')->on('locations')->onDelete('restrict');

            $table->foreign('launch_video')->references('object_id')->on('objects')->onDelete('set null');
            $table->foreign('mission_patch')->references('object_id')->on('objects')->onDelete('set null');
            $table->foreign('press_kit')->references('object_id')->on('objects')->onDelete('set null');
            $table->foreign('cargo_manifest')->references('object_id')->on('objects')->onDelete('set null');
            $table->foreign('prelaunch_press_conference')->references('object_id')->on('objects')->onDelete('set null');
            $table->foreign('postlaunch_press_conference')->references('object_id')->on('objects')->onDelete('set null');
            $table->foreign('featured_image')->references('object_id')->on('objects')->onDelete('set null');
        });

        Schema::table('notes', function(Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('object_id')->references('object_id')->on('objects')->onDelete('cascade');
        });

        Schema::table('objects', function(Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');
            $table->foreign('mission_id')->references('mission_id')->on('missions')->onDelete('set null');

            $table->foreign('publisher_id')->references('publisher_id')->on('publishers')->onDelete('set null');
            $table->foreign('tweeter_id')->references('tweeter_id')->on('tweeters')->onDelete('set null');
        });

        Schema::table('taggables_pivot', function(Blueprint $table) {
            $table->foreign('tag_id')->references('tag_id')->on('tags')->onDelete('cascade');
        });

        Schema::table('part_flights_pivot', function(Blueprint $table) {
            $table->foreign('mission_id')->references('mission_id')->on('missions')->onDelete('cascade');
            $table->foreign('landing_site_id')->references('location_id')->on('locations')->onDelete('restrict');
            $table->foreign('part_id')->references('part_id')->on('parts')->onDelete('restrict');
        });

        Schema::table('payloads', function(Blueprint $table) {
            $table->foreign('mission_id')->references('mission_id')->on('missions')->onDelete('cascade');
        });

        Schema::table('prelaunch_events', function(Blueprint $table) {
            $table->foreign('mission_id')->references('mission_id')->on('missions')->onDelete('cascade');
        });

        Schema::table('profiles', function(Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('favorite_mission')->references('mission_id')->on('missions')->onDelete('set null');
            $table->foreign('favorite_mission_patch')->references('mission_id')->on('missions')->onDelete('set null');
        });

        Schema::table('searches', function(Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');
        });

        Schema::table('smses', function(Blueprint $table) {
            $table->foreign('notification_id')->references('notification_id')->on('notifications')->onDelete('set null');
        });

        Schema::table('spacecraft_flights_pivot', function(Blueprint $table) {
            $table->foreign('mission_id')->references('mission_id')->on('missions')->onDelete('cascade');
            $table->foreign('spacecraft_id')->references('spacecraft_id')->on('spacecraft')->onDelete('restrict');
        });

        Schema::table('telemetry', function(Blueprint $table) {
            $table->foreign('mission_id')->references('mission_id')->on('missions')->onDelete('cascade');
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
