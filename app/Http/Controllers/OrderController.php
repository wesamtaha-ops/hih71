<?php

namespace App\Http\Controllers;

use App\Traits\ZoomMeetingTrait;
use Illuminate\Http\Request;

use \App\Models\Topic;
use \App\Models\Level;
use \App\Models\Teacher;
use \App\Models\Transfer;
use \App\Models\TeacherLevel;
use \App\Models\TeacherCurriculum;
use \App\Models\TeacherTopic;
use \App\Models\TeacherTrain;
use \App\Models\TeacherStudyType;
use \App\Models\TeacherExperience;
use \App\Models\TeacherCertificate;
use \App\Models\Review;
use \App\Models\Order;
use \App\Models\TeacherPackage;

use \App\Models\User;
use \App\Models\Language;
use \App\Models\Curriculum;
use \App\Models\LanguageLevel;
use \App\Models\Currency;
use \App\Models\Country;
use Auth;

use Illuminate\Support\Arr;

use \App\Http\Services\ParsingService;

class OrderController extends Controller
{
    use ZoomMeetingTrait;

    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;

    public function show($id)
    {
        $meeting = $this->get($id);

        return view('meetings.index', compact('meeting'));
    }

    
    public function book_single(Request $request, $teacher_id) {
        $teacher = User::whereId($teacher_id);
        $teacher_info = $teacher->with(['country','teacher', 'teacher.availability'])->first();
        $topics_arr = TeacherTopic::where('teacher_id', $teacher_id)->pluck('topic_id');
        $topics = ParsingService::parseTopics(Topic::where('parent_id', '!=', null)->whereIn('id', $topics_arr)->get()->toArray());

        $dates_by_orders = Order::where('teacher_id',$teacher_id)->get(['date', 'time'])->toArray();
        $date_by_teacher_availability = $teacher_info->teacher->availability->toArray();

        $temp_arr = [];
        foreach($date_by_teacher_availability as $date) {
            $temp_arr[] = [
                'time' => $date['time'],
                'date' => $date['date']
            ];
        }
        $date_by_teacher_availability = $temp_arr;

        
        $availablility_arr = array_filter($date_by_teacher_availability, function ($element) use ($dates_by_orders) {
            return !in_array($element, $dates_by_orders);
        });

        return view('book_single', [
            'teacher' => $teacher_info,
            'topics' => $topics,
            'availablility_arr' => $availablility_arr
        ]);
    }

    public function book_single_func(Request $request) {

        $teacher = Teacher::find($request->teacher_id)->first();

        $fees = convert_to_default_currency($teacher->currency_id, $teacher->fees);

        if($fees > Transfer::get_user_balance()) {
            return redirect(route('wallet', ['success' => 0, 'message' => 'You don\'t credit']));
        }

        $data = [
            'student_id' => \Auth::id(),
            'teacher_id' => $request->teacher_id,
            'topic_id' => $request->topic,
            'date' => explode(' ', $request->time)[0],
            'time' => explode(' ', $request->time)[1],
            'fees' => $teacher->fees,
            'currency_id' => $teacher->currency_id
        ];  


        // add order
        $order_id = Order::insertGetId($data);

        // add transfer
        Transfer::insert([
            'user_id' => \Auth::id(),
            'amount' => $fees,
            'type' => 'order',
            'order_id' => $order_id,
            'approved' => '1',
            'currency_id' => $teacher->currency_id
        ]);

        return redirect(route('wallet', ['success' => '1', 'message' => 'Order has been submitted successfully!']));
    }


    public function book_package_func(Request $request) {
        $fees = 0;
        $currency_id = 0;

        $package_id = $request->package_id;

        $package = TeacherPackage::find($package_id);

        $data = [
            'student_id' => \Auth::id(),
            'teacher_id' => $package->teacher_id,
            'currency_id' => $package->currency_id,
            'fees' => $package->fees
        ];  


        // add order
        $order_id = Order::insertGetId($data);

        // add transfer
        Transfer::insert([
            'user_id' => \Auth::id(),
            'amount' => $package->fees,
            'type' => 'order',
            'order_id' => $order_id,
            'approved' => '1',
            'currency_id' => $package->currency_id
        ]);

        return redirect(route('wallet', ['success' => '1', 'message' => 'Order has been submitted successfully!']));
    }

    public function lessons() {
        $orders = Order::where('student_id', \Auth::id())->with(['teacher', 'topic'])->get();

        return view('lessons', ['orders' => $orders]);
    }

}