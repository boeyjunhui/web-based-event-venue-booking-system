<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\XRayController;


//todo xray
class EventVenueController extends Controller
{

    public function __construct(XRayController $xRayController)
    {
        $this->xRayController = $xRayController;
    }
    /* ========================================
    Super Admin & Event Venue Owner
    ======================================== */
    // display add form
    public function add()
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $eventVenueOwners = DB::table('event_venue_owners')
                ->select('event_venue_owners.id', 'event_venue_owners.first_name', 'event_venue_owners.last_name', 'event_venue_owners.email')
                ->where('event_venue_owners.status', 1)
                ->orderBy('event_venue_owners.created_at', 'asc')
                ->get();

            $eventTypes = DB::table('event_types')
                ->select('event_types.id', 'event_types.event_type_name')
                ->where('event_types.status', 1)
                ->orderBy('event_types.created_at', 'asc')
                ->get();

            return view('event-venues.management-system.add', compact('eventVenueOwners', 'eventTypes'));
        }
    }

    // insert data into database
    public function create(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            if (session('user_role') == "Super Admin") {
                $request->validate([
                    'eventVenueOwner' => 'required',
                    'eventType' => 'required',
                    'eventVenueName' => 'required',
                    'eventVenueEmail' => 'required|email',
                    'eventVenuePhoneNumber' => 'required',
                    'address' => 'required',
                    'postalCode' => 'required',
                    'city' => 'required',
                    'state' => 'required',
                    'country' => 'required',
                    'eventVenueDescription' => 'required',
                    'sizeMeasurement' => 'required',
                    'sizeMeasurementUnit' => 'required',
                    'maximumGuests' => 'required|integer|min:1',
                    'availability' => 'required',
                    'packagesPricing' => 'required',
                    'amenities' => 'required',
                    'accessibility' => 'required',
                    'addOnServices' => 'required'
                ]);
            } else if (session('user_role') == "Event Venue Owner") {
                $request->validate([
                    'eventType' => 'required',
                    'eventVenueName' => 'required',
                    'eventVenueEmail' => 'required|email',
                    'eventVenuePhoneNumber' => 'required',
                    'address' => 'required',
                    'postalCode' => 'required',
                    'city' => 'required',
                    'state' => 'required',
                    'country' => 'required',
                    'eventVenueDescription' => 'required',
                    'sizeMeasurement' => 'required',
                    'sizeMeasurementUnit' => 'required',
                    'maximumGuests' => 'required|integer|min:1',
                    'availability' => 'required',
                    'packagesPricing' => 'required',
                    'amenities' => 'required',
                    'accessibility' => 'required',
                    'addOnServices' => 'required'
                ]);
            }

            // event venue images
            $image = [];
            $combinedEventVenueImages = [];

            if (!empty($request->eventVenueImages)) {
                foreach ($request->eventVenueImages as $image) {
                    $randomString = Str::random(30);
                    $eventVenueImagesFilename = $randomString . '.' . $image->getClientOriginalExtension();
                    // Get the path of the uploaded file
                    $sourceFilePath = $image->getRealPath();

                    // Get the content type (MIME type) of the uploaded file
                    $contentType = $image->getClientMimeType();

                    // Create S3 client
                    $s3 = \App::make('aws')->createClient('s3');
                    try {
                        $result = $s3->putObject([
                            'Bucket' => env('AWS_BUCKET'),
                            'Key' => 'uploads/event-venues/' . $eventVenueImagesFilename,
                            'SourceFile' => $sourceFilePath,
                            'ACL' => 'public-read',
                            'ContentType' => $contentType,
                        ]);
                    } catch (\Aws\S3\Exception\S3Exception $e) {
                        // Catch any S3 exceptions and return an error message
                        print($e->getMessage());
                    }
                    $combinedEventVenueImages[] = $eventVenueImagesFilename;
                }

                $allEventVenueImages = implode(',', $combinedEventVenueImages);
            } else {
                $allEventVenueImages = "";
            }

            if (session('user_role') == "Super Admin") {
                DB::table('event_venues')
                    ->insert([
                        'id' => Str::random(30),
                        'event_venue_owner_id' => $request->eventVenueOwner,
                        'event_type_id' => $request->eventType,
                        'event_venue_name' => $request->eventVenueName,
                        'event_venue_email' => $request->eventVenueEmail,
                        'event_venue_phone_number' => $request->eventVenuePhoneNumber,
                        'address' => $request->address,
                        'postal_code' => $request->postalCode,
                        'city' => $request->city,
                        'state' => $request->state,
                        'country' => $request->country,
                        'event_venue_description' => $request->eventVenueDescription,
                        'size_measurement' => $request->sizeMeasurement,
                        'size_measurement_unit' => $request->sizeMeasurementUnit,
                        'maximum_guests' => $request->maximumGuests,
                        'availability' => $request->availability,
                        'packages_pricing' => $request->packagesPricing,
                        'amenities' => $request->amenities,
                        'accessibility' => $request->accessibility,
                        'add_on_services' => $request->addOnServices,
                        'event_venue_images' => $allEventVenueImages,
                        'status' => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
            } else if (session('user_role') == "Event Venue Owner") {
                DB::table('event_venues')
                    ->insert([
                        'id' => Str::random(30),
                        'event_venue_owner_id' => session('user')->id,
                        'event_type_id' => $request->eventType,
                        'event_venue_name' => $request->eventVenueName,
                        'event_venue_email' => $request->eventVenueEmail,
                        'event_venue_phone_number' => $request->eventVenuePhoneNumber,
                        'address' => $request->address,
                        'postal_code' => $request->postalCode,
                        'city' => $request->city,
                        'state' => $request->state,
                        'country' => $request->country,
                        'event_venue_description' => $request->eventVenueDescription,
                        'size_measurement' => $request->sizeMeasurement,
                        'size_measurement_unit' => $request->sizeMeasurementUnit,
                        'maximum_guests' => $request->maximumGuests,
                        'availability' => $request->availability,
                        'packages_pricing' => $request->packagesPricing,
                        'amenities' => $request->amenities,
                        'accessibility' => $request->accessibility,
                        'add_on_services' => $request->addOnServices,
                        'event_venue_images' => $allEventVenueImages,
                        'status' => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
            }

            return redirect('/evbs/event-venues')->with('success', 'Event venue created successfully!');
        }
    }

    // get all rows of data from database
    public function viewAll()
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            if (session('user_role') == "Super Admin") {
                $eventVenues = DB::table('event_venues')
                    ->select('event_venues.*', 'event_venue_owners.first_name', 'event_venue_owners.last_name', 'event_types.event_type_name')
                    ->join('event_venue_owners', 'event_venue_owners.id', '=', 'event_venues.event_venue_owner_id')
                    ->join('event_types', 'event_types.id', '=', 'event_venues.event_type_id')
                    ->orderBy('event_venues.created_at', 'desc')
                    ->get();
            } else if (session('user_role') == "Event Venue Owner") {
                $eventVenueOwnerID = session('user')->id;

                $eventVenues = DB::table('event_venues')
                    ->select('event_venues.*', 'event_venue_owners.first_name', 'event_venue_owners.last_name', 'event_types.event_type_name')
                    ->join('event_venue_owners', 'event_venue_owners.id', '=', 'event_venues.event_venue_owner_id')
                    ->join('event_types', 'event_types.id', '=', 'event_venues.event_type_id')
                    ->where('event_venues.event_venue_owner_id', $eventVenueOwnerID)
                    ->orderBy('event_venues.created_at', 'desc')
                    ->get();
            }

            return view('event-venues.management-system.view-all', compact('eventVenues'));
        }
    }

    // get one row of data from database
    public function view(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $eventVenueID = $request->segment(3);

            $eventVenue = DB::table('event_venues')
                ->select('event_venues.*', 'event_venue_owners.first_name', 'event_venue_owners.last_name', 'event_types.event_type_name')
                ->join('event_venue_owners', 'event_venue_owners.id', '=', 'event_venues.event_venue_owner_id')
                ->join('event_types', 'event_types.id', '=', 'event_venues.event_type_id')
                ->where('event_venues.id', $eventVenueID)
                ->first();

            return view('event-venues.management-system.view', compact('eventVenue'));
        }
    }

    // display edit form
    public function edit(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $eventVenueID = $request->segment(3);

            $eventVenue = DB::table('event_venues')
                ->select('event_venues.*')
                ->where('event_venues.id', $eventVenueID)
                ->first();

            $eventVenueOwners = DB::table('event_venue_owners')
                ->select('event_venue_owners.id', 'event_venue_owners.first_name', 'event_venue_owners.last_name', 'event_venue_owners.email')
                ->where('event_venue_owners.status', 1)
                ->orderBy('event_venue_owners.created_at', 'asc')
                ->get();

            $eventTypes = DB::table('event_types')
                ->select('event_types.id', 'event_types.event_type_name')
                ->where('event_types.status', 1)
                ->orderBy('event_types.created_at', 'asc')
                ->get();

            return view('event-venues.management-system.edit', compact('eventVenue', 'eventVenueOwners', 'eventTypes'));
        }
    }

    // update new data to database
    public function update(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            if (session('user_role') == "Super Admin") {
                $request->validate([
                    'eventVenueOwner' => 'required',
                    'eventType' => 'required',
                    'eventVenueName' => 'required',
                    'eventVenueEmail' => 'required|email',
                    'eventVenuePhoneNumber' => 'required',
                    'address' => 'required',
                    'postalCode' => 'required',
                    'city' => 'required',
                    'state' => 'required',
                    'country' => 'required',
                    'eventVenueDescription' => 'required',
                    'sizeMeasurement' => 'required',
                    'sizeMeasurementUnit' => 'required',
                    'maximumGuests' => 'required|integer|min:1',
                    'availability' => 'required',
                    'packagesPricing' => 'required',
                    'amenities' => 'required',
                    'accessibility' => 'required',
                    'addOnServices' => 'required'
                ]);
            } else if (session('user_role') == "Event Venue Owner") {
                $request->validate([
                    'eventType' => 'required',
                    'eventVenueName' => 'required',
                    'eventVenueEmail' => 'required|email',
                    'eventVenuePhoneNumber' => 'required',
                    'address' => 'required',
                    'postalCode' => 'required',
                    'city' => 'required',
                    'state' => 'required',
                    'country' => 'required',
                    'eventVenueDescription' => 'required',
                    'sizeMeasurement' => 'required',
                    'sizeMeasurementUnit' => 'required',
                    'maximumGuests' => 'required|integer|min:1',
                    'availability' => 'required',
                    'packagesPricing' => 'required',
                    'amenities' => 'required',
                    'accessibility' => 'required',
                    'addOnServices' => 'required'
                ]);
            }

            $eventVenueID = $request->segment(3);

            $eventVenue = DB::table('event_venues')
                ->select('event_venues.*')
                ->where('event_venues.id', $eventVenueID)
                ->first();

            // add new event venue images if not exist, merge existing & new event venue images if exist
            $eventVenueImagesOldFilename = $eventVenue->event_venue_images;
            $image = [];
            $combinedEventVenueImages = [];

            if (!empty($request->eventVenueImages)) {
                foreach ($request->eventVenueImages as $image) {
                    $randomString = Str::random(30);
                    $eventVenueImagesFilename = $randomString . '.' . $image->getClientOriginalExtension();
                    // Get the path of the uploaded file
                    $sourceFilePath = $image->getRealPath();

                    // Get the content type (MIME type) of the uploaded file
                    $contentType = $image->getClientMimeType();

                    // Create S3 client
                    $s3 = \App::make('aws')->createClient('s3');
                    try {
                        $result = $s3->putObject([
                            'Bucket' => env('AWS_BUCKET'),
                            'Key' => 'uploads/event-venues/' . $eventVenueImagesFilename,
                            'SourceFile' => $sourceFilePath,
                            'ACL' => 'public-read',
                            'ContentType' => $contentType,
                        ]);
                    } catch (\Aws\S3\Exception\S3Exception $e) {
                        // Catch any S3 exceptions and return an error message
                        print($e->getMessage());
                    }




                    //$image->move(public_path('/uploads/event-venues'), $eventVenueImagesFilename);
                    $combinedEventVenueImages[] = $eventVenueImagesFilename;
                }

                // if event venue images are empty, add new images, else merge existing & new images together
                if ($eventVenueImagesOldFilename == "") {
                    $allEventVenueImages = implode(',', $combinedEventVenueImages);
                } else {
                    $existingEventVenueImages = [];
                    $existingEventVenueImages = explode(',', $eventVenueImagesOldFilename);

                    $newEventVenueImages = [];
                    $newEventVenueImages = array_merge($existingEventVenueImages, $combinedEventVenueImages);

                    $allEventVenueImages = implode(',', $newEventVenueImages);
                }
            } else {
                $allEventVenueImages = $eventVenueImagesOldFilename;
            }

            if (session('user_role') == "Super Admin") {
                DB::table('event_venues')
                    ->where('event_venues.id', $eventVenueID)
                    ->update([
                        'event_venue_owner_id' => $request->eventVenueOwner,
                        'event_type_id' => $request->eventType,
                        'event_venue_name' => $request->eventVenueName,
                        'event_venue_email' => $request->eventVenueEmail,
                        'event_venue_phone_number' => $request->eventVenuePhoneNumber,
                        'address' => $request->address,
                        'postal_code' => $request->postalCode,
                        'city' => $request->city,
                        'state' => $request->state,
                        'country' => $request->country,
                        'event_venue_description' => $request->eventVenueDescription,
                        'size_measurement' => $request->sizeMeasurement,
                        'size_measurement_unit' => $request->sizeMeasurementUnit,
                        'maximum_guests' => $request->maximumGuests,
                        'availability' => $request->availability,
                        'packages_pricing' => $request->packagesPricing,
                        'amenities' => $request->amenities,
                        'accessibility' => $request->accessibility,
                        'add_on_services' => $request->addOnServices,
                        'event_venue_images' => $allEventVenueImages,
                        'updated_at' => now()
                    ]);
            } else if (session('user_role') == "Event Venue Owner") {
                DB::table('event_venues')
                    ->where('event_venues.id', $eventVenueID)
                    ->update([
                        'event_type_id' => $request->eventType,
                        'event_venue_name' => $request->eventVenueName,
                        'event_venue_email' => $request->eventVenueEmail,
                        'event_venue_phone_number' => $request->eventVenuePhoneNumber,
                        'address' => $request->address,
                        'postal_code' => $request->postalCode,
                        'city' => $request->city,
                        'state' => $request->state,
                        'country' => $request->country,
                        'event_venue_description' => $request->eventVenueDescription,
                        'size_measurement' => $request->sizeMeasurement,
                        'size_measurement_unit' => $request->sizeMeasurementUnit,
                        'maximum_guests' => $request->maximumGuests,
                        'availability' => $request->availability,
                        'packages_pricing' => $request->packagesPricing,
                        'amenities' => $request->amenities,
                        'accessibility' => $request->accessibility,
                        'add_on_services' => $request->addOnServices,
                        'event_venue_images' => $allEventVenueImages,
                        'updated_at' => now()
                    ]);
            }

            return redirect('/evbs/event-venues')->with('success', 'Event venue updated successfully!');
        }
    }

    // activate a data
    public function activate(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $eventVenueID = $request->segment(3);

            DB::table('event_venues')
                ->where('event_venues.id', $eventVenueID)
                ->update([
                    'status' => 1,
                    'updated_at' => now()
                ]);

            return redirect('/evbs/event-venues')->with('success', 'Event venue activated successfully!');
        }
    }

    // deactivate a data
    public function deactivate(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $eventVenueID = $request->segment(3);

            DB::table('event_venues')
                ->where('event_venues.id', $eventVenueID)
                ->update([
                    'status' => 0,
                    'updated_at' => now()
                ]);

            return redirect('/evbs/event-venues')->with('success', 'Event venue deactivated successfully!');
        }
    }

    // delete single event venue image
    public function deleteSingleEventVenueImage(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $eventVenueID = $request->segment(3);

            $singleEventVenueImage = $request->singleEventVenueImage;
            // Create S3 client
            $s3 = \App::make('aws')->createClient('s3');
            try {
                $result = $s3->deleteObject([
                    'Bucket' => env('AWS_BUCKET'),
                    'Key' => 'uploads/event-venues/' . $singleEventVenueImage,
                ]);
            } catch (\Aws\S3\Exception\S3Exception $e) {
                // Catch any S3 exceptions and return an error message
                print($e->getMessage());
            }
            $existingEventVenueImages = [];
            $existingEventVenueImages = explode(',', $request->eventVenueImages);

            $searchEventVenueImage = array_search($singleEventVenueImage, $existingEventVenueImages);

            if ($searchEventVenueImage !== false) {
                unset($existingEventVenueImages[$searchEventVenueImage]);
            }

            $sortEventVenueImages = [];
            $sortEventVenueImages = array_values($existingEventVenueImages);

            $newEventVenueImages = implode(',', $sortEventVenueImages);

            DB::table('event_venues')
                ->where('event_venues.id', $eventVenueID)
                ->update([
                    'event_venue_images' => $newEventVenueImages,
                    'updated_at' => now()
                ]);

            return redirect('/evbs/event-venues/' . $eventVenueID)->with('success', 'Event venue image deleted successfully!');
        }
    }

    // delete all event venue images
    public function deleteAllEventVenueImages(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $eventVenueID = $request->segment(3);

            $allEventVenueImages = [];
            $allEventVenueImages = explode(',', $request->allEventVenueImages);

            for ($i = 0; $i < count($allEventVenueImages); $i++) {
                $s3 = \App::make('aws')->createClient('s3');
                try {
                    $result = $s3->deleteObject([
                        'Bucket' => env('AWS_BUCKET'),
                        'Key' => 'uploads/event-venues/' . $allEventVenueImages[$i],
                    ]);
                } catch (\Aws\S3\Exception\S3Exception $e) {
                    // Catch any S3 exceptions and return an error message
                    print($e->getMessage());
                }
            }

            DB::table('event_venues')
                ->where('event_venues.id', $eventVenueID)
                ->update([
                    'event_venue_images' => "",
                    'updated_at' => now()
                ]);

            return redirect('/evbs/event-venues/' . $eventVenueID)->with('success', 'All event venue images deleted successfully!');
        }
    }

    // delete data from database
    public function delete(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $eventVenueID = $request->segment(3);

            // delete event venue images from file directory
            $eventVenueImages = [];
            $eventVenueImages = explode(',', $request->eventVenueImages);

            for ($i = 0; $i < count($eventVenueImages); $i++) {
                $s3 = \App::make('aws')->createClient('s3');
                try {
                    $result = $s3->deleteObject([
                        'Bucket' => env('AWS_BUCKET'),
                        'Key' => 'uploads/event-venues/' . $eventVenueImages[$i],
                    ]);
                } catch (\Aws\S3\Exception\S3Exception $e) {
                    // Catch any S3 exceptions and return an error message
                    print($e->getMessage());
                }
            }

            DB::table('event_venues')
                ->where('event_venues.id', $eventVenueID)
                ->delete();

            return redirect('/evbs/event-venues')->with('success', 'Event venue deleted successfully!');
        }
    }

    /* ========================================
    Guest
    ======================================== */
    // view event venue
    public function viewEventVenue()
    {
        $eventTypes = DB::table('event_types')
            ->select('event_types.*')
            ->where('event_types.status', 1)
            ->orderBy('event_types.created_at', 'asc')
            ->get();

        $eventVenues = DB::table('event_venues')
            ->select('event_venues.id', 'event_venues.event_venue_name', 'event_venues.city', 'event_venues.maximum_guests', 'event_venues.event_venue_images', 'event_types.event_type_name')
            ->join('event_types', 'event_types.id', '=', 'event_venues.event_type_id')
            ->where('event_venues.status', 1)
            ->orderBy('event_venues.created_at', 'asc')
            ->get();

        return view('event-venues.booking-system.view-all', compact('eventTypes', 'eventVenues'));
    }

    // view specific event type's event venue
    public function viewSpecificEventTypeVenue(Request $request)
    {
        $eventTypes = DB::table('event_types')
            ->select('event_types.*')
            ->where('event_types.status', 1)
            ->orderBy('event_types.created_at', 'asc')
            ->get();

        $eventType = $request->eventType;

        $eventVenues = DB::table('event_venues')
            ->select('event_venues.id', 'event_venues.event_venue_name', 'event_venues.city', 'event_venues.maximum_guests', 'event_venues.event_venue_images', 'event_types.event_type_name')
            ->join('event_types', 'event_types.id', '=', 'event_venues.event_type_id')
            ->where('event_venues.event_type_id', $eventType)
            ->where('event_venues.status', 1)
            ->orderBy('event_venues.created_at', 'asc')
            ->get();

        return view('event-venues.booking-system.view-all', compact('eventTypes', 'eventVenues'));
    }

    // search event venue
    public function searchEventVenue(Request $request)
    {
        $eventTypes = DB::table('event_types')
            ->select('event_types.*')
            ->where('event_types.status', 1)
            ->orderBy('event_types.created_at', 'asc')
            ->get();

        $search = $request->search;

        $eventVenues = DB::table('event_venues')
            ->select('event_venues.id', 'event_venues.event_venue_name', 'event_venues.city', 'event_venues.maximum_guests', 'event_venues.event_venue_images', 'event_types.event_type_name')
            ->join('event_types', 'event_types.id', '=', 'event_venues.event_type_id')
            ->where('event_venues.event_venue_name', 'like', "%{$search}%")
            ->orWhere('event_venues.city', 'like', "%{$search}%")
            ->orWhere('event_venues.state', 'like', "%{$search}%")
            ->where('event_venues.status', 1)
            ->orderBy('event_venues.created_at', 'asc')
            ->get();

        return view('event-venues.booking-system.view-all', compact('eventTypes', 'eventVenues'));
    }
}