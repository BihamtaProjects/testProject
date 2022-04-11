<?php
/** @noinspection PhpUnused */
namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Covent;
use App\Models\Instructor;
use App\Models\Keyword;
use App\Models\Selectedgroup;
use App\Models\Subject;
use App\Models\User;
use App\Scopes\ActiveCovents;
use Illuminate\Http\Request;

class CoventsController extends Controller
{
    public function searchfaq(Request $request)
    {
        return response()->json(
            Faq::where('question',
                'LIKE',
                '%' . $request->input('keyword') . '%')
                ->select(['faqs.id', 'faqs.question'])->get());
    }
    public function updateCoventFaq(Request $request, $id)
    {
        $covent_id = $id;
        $covent = Covent::where('id', $covent_id)->withoutglobalScope(ActiveCovents::class)->first();
        $faq_id =  $request->input('faq_id');
        $covent->faqs()->attach($faq_id);

        return response()->json($covent);
    }

    public function searchkeyword(Request $request)
    {
        return response()->json(
            Keyword::where('title',
                'LIKE',
                '%' . $request->input('keyword') . '%')
                ->select(['keywords.id', 'keywords.title'])->get());
    }
    public function updateCoventKeyword(Request $request, $id)
    {
        $covent_id = $id;
        $covent = Covent::where('id', $covent_id)->withoutglobalScope(ActiveCovents::class)->first();
        $keyword_id =  $request->input('keyword_id');
        $covent->keywords()->attach($keyword_id);

        return response()->json($covent);
    }

    public function searchsubject(Request $request)
    {
        return response()->json(
            Subject::where('name',
                'LIKE',
                '%' . $request->input('keyword') . '%')
                ->select(['subjects.id', 'subjects.name'])->get());
    }
    public function updateCoventSubject(Request $request, $id)
    {
        $covent_id = $id;
        $covent = Covent::where('id', $covent_id)->withoutglobalScope(ActiveCovents::class)->first();
        $subject_id =  $request->input('subject_id');
        $covent->subjects()->attach($subject_id);

        return response()->json($covent);
    }

    public function searchselected(Request $request)
    {
        return response()->json(
            Selectedgroup::where('title',
                'LIKE',
                '%' . $request->input('keyword') . '%')
                ->select(['selectedgroups.id', 'selectedgroups.title'])->get());
    }
    public function updateCoventSelected(Request $request, $id)
    {
        $covent_id = $id;
        $covent = Covent::where('id', $covent_id)->withoutglobalScope(ActiveCovents::class)->first();
        $selectedgroup_id =  $request->input('selectedgroup_id');
        $covent->selectedgroups()->attach($selectedgroup_id);

        return response()->json($covent);
    }

    public function searchinstructor(Request $request)
    {
        $instructors = Instructor::where('active',1)->pluck('user_id');
        return response()->json(
            user::whereIn('id',$instructors)->where('name',
                'LIKE',
                '%' . $request->input('keyword') . '%')
                ->select(['users.id', 'users.name'])->get());
    }
    public function updateCoventInstructor(Request $request, $id)
    {
        $covent_id = $id;
        $covent = Covent::where('id', $covent_id)->withoutglobalScope(ActiveCovents::class)->first();
        $user_id =  $request->input('user_id');
        $covent->instructors()->attach($user_id);

        return response()->json($covent);
    }

    public function destroyFaq($covent,Faq $faq)
    {   $covent = Covent::where('id',$covent)->withoutglobalScope(ActiveCovents::class)->first();
        $covent->faqs()->detach($faq->id);
        return redirect()->back();
    }
    public function destroyKeyword($covent,Keyword $keyword)
    {
        $covent = Covent::where('id',$covent)->withoutglobalScope(ActiveCovents::class)->first();
        $covent->keywords()->detach($keyword->id);
        return redirect()->back();
    }
    public function destroySubject($covent,Subject $subject)
    {
        $covent = Covent::where('id',$covent)->withoutglobalScope(ActiveCovents::class)->first();
        $covent->subjects()->detach($subject->id);
        return redirect()->back();
    }
    public function destroySelectedgroup($covent,Selectedgroup $selectedgroup)
    {
        $covent = Covent::where('id',$covent)->withoutglobalScope(ActiveCovents::class)->first();
        $covent->selectedgroups()->detach($selectedgroup->id);
        return redirect()->back();
    }
    public function destroyInstructor($covent,Instructor $instructor)
    {
        $covent = Covent::where('id',$covent)->withoutglobalScope(ActiveCovents::class)->first();
        $covent->instructors()->detach($instructor->id);
        return redirect()->back();
    }
}
