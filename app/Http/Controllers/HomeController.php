<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Topic;
use \App\Models\Level;
use \App\Models\Teacher;
use \App\Models\Transfer;
use \App\Models\TeacherLevel;
use \App\Models\TeacherCurriculum;
use \App\Models\TeacherPackage;
use \App\Models\TeacherTopic;
use \App\Models\TeacherTrain;
use \App\Models\TeacherStudyType;
use \App\Models\TeacherExperience;
use \App\Models\TeacherCertificate;
use \App\Models\TeacherAvailablity;
use \App\Models\Review;
use \App\Models\Order;

use \App\Models\User;
use \App\Models\Language;
use \App\Models\Curriculum;
use \App\Models\LanguageLevel;
use \App\Models\Currency;
use \App\Models\Country;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

use Illuminate\Support\Facades\Session;

use Carbon\Carbon;

use \App\Mail\FinishProfile;


use \App\Http\Services\ParsingService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('teacher');
    }

    public function index()
    {
        $teachers = User::where('type', 'teacher')->with('teacher')->take(10)->get();
        $data = [
            'topics' => ParsingService::parseTopics(Topic::where('parent_id', '!=' ,null)->get()),
            'main_topics' => ParsingService::parseTopics(Topic::where('parent_id', '=' ,null)->get()),
            'curriculums' => ParsingService::parseCurriculum(Curriculum::get()),
            'teachers' => $teachers
        ];

        return view('home', $data);
    }

    public function update_locale($locale = 'en') {
        app()->setLocale($locale);
        session()->put('locale', $locale);

        if(\Auth::check()) {
            $balance = convert_to_currency(env('DEFAULT_CURRENCY_ID'), Transfer::get_user_balance());
            Session::put('balance' , $balance);
        }

        return redirect()->back();
    }

    public function update_currency($currency_id = '1') {
        $currencies = session()->get('currencies');
        
        foreach($currencies as $currency) {
            if($currency['id'] == $currency_id) {
                session()->put('current_currency', $currency);
            }
        }

        if(\Auth::check()) {
            $balance = convert_to_currency(env('DEFAULT_CURRENCY_ID'), Transfer::get_user_balance());
            Session::put('balance' , $balance);
        }

        return redirect()->back();
    }

    public function search(Request $request) {

        $current_page = $request->page ?? 1;

        $take = 20;
        $skip = ($current_page - 1) * $take;

        $sort = $request->sort ?? 'asc';
        

        $teachers = User::where('type', 'teacher')->where('is_verified', '1')->where('is_approved', 1);

        if($request->teacher_name) {
            $teacher_name = $request->teacher_name;

            $teachers->where('name', 'LIKE', '%'.$teacher_name.'%');
        }
        
        if($request->topic_id) {
            $topics_id = $request->topic_id;

            $teachers->whereHas('teacher.topics', function($q) use($topics_id){
                $q->where('topic_id', $topics_id);
            });
        }

        if($request->level) {
            $level_id = $request->level;

            $teachers->whereHas('teacher.levels', function($q) use($level_id){
                $q->where('level_id', $level_id);
            });
        }

        if($request->gender && $request->gender != "-1") {
            $teachers->where('gender', $request->gender);
        }

        if($request->country_id && $request->country_id != "-1") {
            $teachers->where('country_id', $request->country_id);
        }

        if($request->curriculum_id) {
            $curriculum_id = $request->curriculum_id;

            $teachers->whereHas('teacher.curriculums', function($q) use($curriculum_id){
                $q->where('curriculum_id', $curriculum_id);
            });
        }

        if($request->rate3 || $request->rate4 || $request->rate5) {
            if($request->rate3) {
                $rates = ['3', '0'];
            }
            if($request->rate4) {
                $rates = ['4', '0'];
            }
            if($request->rate5) {
                $rates = ['5', '0'];
            }
        } else {
            $rates = ["0", "3","4","5"];
        }

        $teachers->whereIn('rate', $rates);   

        if($request->language_id) {
            $language_id = $request->language_id;

            $teachers->whereHas('teacher', function($q) use($language_id){
                $q->where('teacher_language','LIKE','%"language":"'.$language_id.'"%');
            });
        }

        if($request->have_assay_experiences == 'on') {
            $teachers->whereHas('teacher', function($q){
                $q->where('have_assay_experiences', 1);   
            });
        }

        
        $teacher_count = $teachers->count();
        $pages_count = ceil($teacher_count / 20);

        $teachers = $teachers->with(['teacher', 'country'])->skip($skip)->take($take)->get();

        return view('search', [
            'teachers' => $teachers,
            'teacher_count' => $teacher_count,
            'current_page' => $current_page,
            'pages_count' => $pages_count,
            'countries' => ParsingService::parseCountries(Country::get()->toArray()),
            'curriculums' => ParsingService::ParseCurriculum(Curriculum::get()->toArray()),
            'main_topics' => ParsingService::parseTopics(Topic::where('parent_id', '!=' ,null)->get()->toArray()),
            'levels' => ParsingService::parseLevels(Level::get()->toArray()),
            'languages' => ParsingService::parseLanguages(Language::get()->toArray()),
            'languages_levels' => ParsingService::parseLanguagesLevels(LanguageLevel::get()->toArray()),
        ]);
    }

    public function teacher_details($slug, Request $request) {
        $teacher = User::where('slug', $slug);
        $teacher_info = $teacher->with([
            'country',
            'teacher', 
            'teacher.levels', 
            'teacher.curriculums', 
            'teacher.certificates', 
            'teacher.experiences', 
            'teacher.topics', 
            'teacher.trains',
            'teacher.packages'
        ])->first();

        if(!$teacher->exists()) {
            abort(404);
        }

        $languages = ParsingService::parseLanguages(Language::get()->toArray());
        $topics = ParsingService::parseTopics(Topic::where('parent_id', '!=', null)->get()->toArray());
        $reviews = [
            'count' => Review::where('to_user_id', $teacher_info->id)->where('approved', 1)->count(),
            'avg' => Review::where('to_user_id', $teacher_info->id)->where('approved', 1)->avg('points'),
            'reviews' => Review::where('to_user_id', $teacher_info->id)->where('approved', 1)->with('user')->get(),
        ];

        if($teacher->exists()) {
            return view('teacher_details', [
                'languages' => $languages,
                'topics' => $topics,
                'teacher' => $teacher_info,
                'reviews' => $reviews
            ]);
        } else {
            abort(404);
        }
        
    }

    public function profile() {
        $teacher_info = Teacher::where('user_id', \Auth::id())->with(['levels', 'curriculums', 'certificates', 'experiences', 'topics', 'trains', 'availability'])->first();

        $topics = Topic::where('parent_id', '!=', null)->get();
        $all_topics = [];
        foreach($topics as $topic) {
            $all_topics[$topic->parent][] = $topic;
        }

        return view('profile', [
            'countries' => ParsingService::parseCountries(Country::get()->toArray()),
            'currencies' => ParsingService::parseCurrencies(Currency::get()->toArray()),
            'languages' => ParsingService::parseLanguages(Language::get()->toArray()),
            'languages_levels' => ParsingService::parseLanguagesLevels(LanguageLevel::get()->toArray()),
            'levels' => ParsingService::parseLevels(Level::get()->toArray()),
            'curriculums' => ParsingService::parseCurriculum(Curriculum::get()->toArray()),
            'topics' => $all_topics,
            'teacher_info' => $teacher_info
        ]);
    }

    public function profile_func(Request $request) {

        $user_data = [];
        $teacher_data = [];
    
        if($request->name)
            $user_data['name'] = $request->name;

        if($request->phone)
            $user_data['phone'] = $request->phone;

        if($request->gender)
            $user_data['gender'] = $request->gender;

        if($request->image)
            $user_data['image'] = $request->image;

        if($request->currency_id)
            $user_data['currency_id'] = $request->currency_id;

        if($request->country_id)
            $user_data['country_id'] = $request->country_id;

        if($request->birthday)
            $user_data['birthday'] = $request->birthday;

        User::whereId(\Auth::id())->update($user_data);


        if($request->languages) {
            $languages_json = [];
            foreach($request->languages as $i => $language) {
                $langauges_levels = $request->langauges_levels; 
                if($language != null && $langauges_levels[$i] != null) {
                    $languages_json[] = ['language' => $language, 'level' => $langauges_levels[$i]];
                }
            }
            $teacher_data['teacher_language'] = json_encode($languages_json);
        }

        if($request->timezone) {
            $teacher_data['timezone'] = json_encode($request->timezone);
        }

        if($request->allow_express == 0) {
            $teacher_data['allow_express'] = 0;
        } else {
            $teacher_data['allow_express'] = 1;
        }

        if($request->days_availablity) {
            $avaiabilities = explode(',', $request->days_availablity);
            TeacherAvailablity::where('teacher_id', \Auth::id())->delete();
            foreach($avaiabilities as $avaiability) {
                $avail = explode(' ', $avaiability);
                TeacherAvailablity::insert([
                    'teacher_id' => \Auth::id(),
                    'date' => $avail[0],
                    'time' => $avail[1]
                ]);
            }
        }

        if($request->video) {
            $teacher_data['video'] = $request->video;
        }

        if($request->heading_en) {
            $teacher_data['heading_en'] = $request->heading_en;
        }

        if($request->fees) {
            $teacher_data['fees'] = $request->fees;
        }


        if($request->description_en) {
            $teacher_data['description_en'] = $request->description_en;
        }

        if($request->heading_ar) {
            $teacher_data['heading_ar'] = $request->heading_ar;
        }

        if($request->description_ar) {
            $teacher_data['description_ar'] = $request->description_ar;
        }

        Teacher::updateOrCreate(
            ['user_id' =>  \Auth::id()],
            $teacher_data
        );

        if($request->levels) {
            TeacherLevel::where('teacher_id', \Auth::id())->delete();
            foreach($request->levels as $level_id) {
                TeacherLevel::insert(['teacher_id' => \Auth::id(), 'level_id' => $level_id]);
            }
        }

        if($request->curriculums) {
            TeacherCurriculum::where('teacher_id', \Auth::id())->delete();
            foreach($request->curriculums as $curriculum_id) {
                TeacherCurriculum::insert(['teacher_id' => \Auth::id(), 'curriculum_id' => $curriculum_id]);
            }
        }

        if($request->topics) {
            TeacherTopic::where('teacher_id', \Auth::id())->delete();
            foreach($request->topics as $topic) {
                TeacherTopic::insert(['teacher_id' => \Auth::id(), 'topic_id' => $topic]);
            }
        }

        if($request->teach_types) {
            TeacherStudyType::where('teacher_id', \Auth::id())->delete();
            foreach($request->teach_types as $type) {
                TeacherStudyType::insert(['teacher_id' => \Auth::id(), 'type' => $type['type'], 'fees' => $type['fee'], 'currency_id' => $type['currency_id']]);
            }
        }

        if($request->work_experience) {
            TeacherExperience::where('teacher_id', \Auth::id())->delete();
            foreach($request->work_experience as $work_experience) {
                if($work_experience['title'] && $work_experience['company']) {
                    TeacherExperience::insert(
                        [
                            'teacher_id' => \Auth::id(), 
                            'title' => $work_experience['title'],
                            'from_date' => Carbon::parse($work_experience['from'])->format('Y-m-d'),
                            'to_date' => Carbon::parse($work_experience['to'])->format('Y-m-d'),
                            'company' => $work_experience['company'] 
                        ]
                    );
                }
            }
        }

        if($request->proffesional_certificates) {
            TeacherTrain::where('teacher_id', \Auth::id())->delete();
            foreach($request->proffesional_certificates as $proffesional_certificate) {
                if($proffesional_certificate['subject'] && $proffesional_certificate['institution']) {
                    TeacherTrain::insert(
                        [
                            'teacher_id' => \Auth::id(), 
                            'subject' => $proffesional_certificate['subject'],
                            'instituation' => $proffesional_certificate['institution'],
                            'from_date' => Carbon::parse($proffesional_certificate['from'])->format('Y-m-d'),
                            'to_date' => Carbon::parse($proffesional_certificate['to'])->format('Y-m-d')
                        ]
                    );
                }
            }
        }

        if($request->higher_educations) {
            TeacherCertificate::where('teacher_id', \Auth::id())->delete();
            foreach($request->higher_educations as $higher_education) {
                if($higher_education['university'] && $higher_education['degree']) {
                    TeacherCertificate::insert(
                        [
                            'teacher_id' => \Auth::id(), 
                            'university' => $higher_education['university'],
                            'degree' => $higher_education['degree'],
                            'from_date' => Carbon::parse($higher_education['from'])->format('Y-m-d'),
                            'to_date' => Carbon::parse($higher_education['to'])->format('Y-m-d'),
                            'image' => $higher_education['image']
                        ]
                    );
                }
            }
        }

        if($request->description_en) { // send email
            Mail::to(\Auth::user()->email)->send(new FinishProfile(\Auth::id()));
        }

    }

    public function wallet(Request $request) {
        if($request->success == '1' && $request->code) {
            Transfer::where('user_id', \Auth::id())->where('verification_code', $request->code)->update(['approved' => 1]);
        }

        $transfers = Transfer::where('user_id', \Auth::id())->where('approved', 1)->get();
        
        $paid = Transfer::where('user_id', \Auth::id())->where('approved', 1)->where('type', 'order')->sum('amount');
        $paid = convert_to_currency(env('DEFAULT_CURRENCY_ID'), $paid);
        $balance = convert_to_currency(env('DEFAULT_CURRENCY_ID'), Transfer::get_user_balance());
        Session::put('balance' , $balance);

        return view('wallet', ['transfers' => $transfers, 'paid' => $paid, 'balance' => $balance]);
    }


    public function change_password() {
        return view('change_password');
    }

    public function packages() {
        $packages = TeacherPackage::where('teacher_id', \Auth::id())->get();
        return view('packages', compact('packages'));
    }

    public function add_package($package_id = null) {
        if($package_id != null) {
            $package = TeacherPackage::find($package_id);
            return view('add_package', compact('package'));
        } else {
            return view('add_package', []);
        }
    }

    public function update_package(Request $request) {
        $request->validate([
            'image' => 'image|mimes:png,jpg,jpeg|max:2048',
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'fees' => 'required',
            'currency_id' => 'required'
        ]);

        $file = $request->image;
        if($file) {
            $imageName = time().'.jpg';
            // Public Folder
            $file->move(public_path('images'), $imageName);
        }

        $data = [
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'fees' => $request->fees,
            'currency_id' => $request->currency_id,
            'teacher_id' => \Auth::id()
        ];

        if(@$imageName) {
            $data['image'] = $imageName;
        }

        if($request->package_id) {
            TeacherPackage::where('id', $request->package_id)->update($data);  
        } else {
            TeacherPackage::insert($data);  
        }   

        return redirect( route('packages', ['success' => 1] ) );
    }

    public function show_package($package_id) {
        $package = TeacherPackage::find($package_id);
        return view('package', ['package' => $package]);
    }

    public function add_review(Request $request) {

        $details = json_encode([
            'time' => $request->rating_time,
            'quality' => $request->rating_quality,
            'easy' => $request->rating_easy
        ]);

        $points = ceil(($request->rating_time + $request->rating_quality + $request->rating_easy) / 3);

        $payload = [
            'from_user_id' => \Auth::id(),
            'to_user_id' => $request->user_id,
            'details' => $details,
            'points' => $points,
            'review' => $request->review
        ];

        if(Review::insert($payload)) {
            return ['success' => 1];
        } else {
            return ['success' => 0];
        }

    }

    public function add_student_review($student_id) {
        return view('add_student_review', ['student_id' => $student_id]);
    }

    public function category_details($category_id) {
        $topics = Topic::where('parent_id', $category_id)->get();
        return view('topics', ['topics' => $topics]);
    }

    public function privacy() {
        if(app()->currentLocale() == 'ar') {
            return view('privacy_ar');
        } else {
            return view('privacy_en');
        }
    }

    public function terms() {
        if(app()->currentLocale() == 'ar') {
            return view('terms_ar');
        } else {
            return view('terms_en');
        }
    }

    public function contact() {
        return view('contact');
    }

    public function contact_func(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        try {
            Mail::to('mhdalalwan@gmail.com')->send(new ContactMail($data['name'], $data['email'], $data['message']));
        } catch (\Throwable $th) { // do nothing
            
        }

        return redirect(route('contact', ['success' => 'Message Sent!']));
        
    }
}


