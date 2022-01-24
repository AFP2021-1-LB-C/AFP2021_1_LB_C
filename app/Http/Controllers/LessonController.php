<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $data = Lesson::with(['course'])
            ->select('lessons.*')
            ->get();
        
        return view('lesson.lesson_list',[
            'isAdmin' => ($this->auth('role_id') === 1),
            'items' => $data ,
            'page_title' => 'Tananyagok' ,
            'page_subtitle' => 'Lista' ,
            'page_links' => [
                (object)['label' => 'Létrehozás', 'link' => '/admin/lesson/create'] ,
            ] ,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //dd($request->request);  // dump and die

        $request->validate([
            'topic'     =>      'required',
            'content'   =>      'required',
        ]);

        $new = Lesson::create([
            
            'topic' => $request->topic,
            'content' => $request->content,
            'course_id' => $request->course_id,
        ]);
        
        if (!is_null($new)) {
        $new->save();

        return redirect()->to('/lesson');
        } else {
            return back()->with('error', 'Hoppá, hiba történt. Próbáld újra.');
        }
    }

    public function create_form()
    {
        $courses = Course::get();
            
        return view('lesson.lesson_create',[ 
            'courses' => $courses,
            'page_title' => 'Tananyagok' ,
            'page_subtitle' => 'Létrehozás' ,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Lesson::where('id', $id) -> first();    
        return view('lesson.lesson_content',[ 
            'topic' => $data -> topic,
            'page_title' => 'Tananyag',
            'page_subtitle' => 'Tartalom',
            'content' => $data -> content,
            'page_links' => [
                (object)['label' => 'Vissza', 'link' => '/lesson'] ,
            ] ,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Lesson::where('id', $id) -> first();
        $courses = Course::get();

        return view('lesson.lesson_edit',[
            
            'id' => $data -> id,
            'topic' => $data -> topic,
            'content' => $data -> content,
            'course_id' => $data -> course_id,
            'courses' => $courses,
            'page_title' => 'Tananyagok' ,
            'page_subtitle' => 'Szerkesztés' ,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'topic'     =>      'required',
            'content'   =>      'required',
        ]);

        $new = Lesson::where('id', $id) -> update([
            
            'topic' => $request->topic,
            'content' => $request->content,
            'course_id' => $request->course_id,
        ]);
        
        if (!is_null($new)) {
        return redirect()->to('/lesson');
        } else {
            return back()->with('error', 'Hoppá, hiba történt. Próbáld újra.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
