<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TeacherController extends Controller
{
    
    /**
     * This function is used to render the login view
     * 
     * @return view
    */
    public function index() 
    {
        return view('login');
    }


    /**
     * This function is used to verify the teacher credentials
     * 
     * @param Illuminate\Http\Request $request
     * @return Route
    */
    public function login(Request $request) {
        
        try {
            $request->validate([
                'email'     => 'required | email',
                'password'  => 'required | min:3 | max:85',
            ]);
    
            // return $request;
            if (Auth::guard('teacher')->attempt($request->only('email', 'password'))) {
    
                $teacher = Auth::guard('teacher')->getLastAttempted();
                Auth::guard('teacher')->login($teacher);
    
                return redirect()->route('teacher.dashboard')->with('flashSuccess', 'Logged in successfully');
            }
            else {
                return redirect()->back()->with('flashError', 'Invalid Credentials, Try again.');
            }
        } catch (\Throwable $th) {
            Log::error('Controller Name :' . __METHOD__ . 'Error : ' . $th->getMessage());
            return redirect()->back()->with('flashError', $th->getMessage());
        }
    }


    /**
     * Logout the teacher instance
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::guard('teacher')->logout();
        return redirect()->route('index')->with('flashSuccess', 'You have successfully logged out!');
    }


    /**
     * This function is used to render the teacher dashboard
     * 
     * @return view
    */
    public function dashboard() 
    {
        $studentList = Student::orderby('id', 'DESC')->get();

        return view('dashboard', compact('studentList'));
    }


    /**
     * This function is used to add a entry in student table
     * 
     * @param Illuminate\Http\Request
     * @return view
    */
    public function addStudentMarks(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'regex:/^[\pL\s\-]+$/u', 'min:3', 'max:85'],
                'subject' => ['required'],
                'marks' => ['required', 'min:0', 'max:100'],
            ]);

            $marks = Student::updateOrInsert([
                'name'      => $request->name,
                'subject'   => $request->subject,
            ],            
            [
                'marks'     => $request->marks,
            ]);

            if ($marks) {
                return redirect()->back()->with('flashSuccess', 'Marks added successfully.');
            }
            else {
                return redirect()->back()->with('flashError', 'Failed to add Marks.');
            }

        } catch (\Throwable $th) {
            Log::error('Controller Name :' . __METHOD__ . 'Error : ' . $th->getMessage());
            return redirect()->back()->with('flashError', $th->getMessage());
        }
    }


    /**
     * This function is used to edit a entry in student table
     * 
     * @param Illuminate\Http\Request
     * @return view
    */
    public function editStudentMarks(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'regex:/^[\pL\s\-]+$/u', 'min:3', 'max:85'],
                'subject' => ['required'],
                'marks' => ['required', 'min:0', 'max:100'],
            ]);

            $marks = Student::updateOrInsert([
                'id'        => $request->id
            ],            
            [
                'name'      => $request->name,
                'subject'   => $request->subject,
                'marks'     => $request->marks,
            ]);

            if ($marks) {
                return redirect()->back()->with('flashSuccess', 'Marks updated successfully.');
            }
            else {
                return redirect()->back()->with('flashError', 'Failed to update Marks.');
            }

        } catch (\Throwable $th) {
            Log::error('Controller Name :' . __METHOD__ . 'Error : ' . $th->getMessage());
            return redirect()->back()->with('flashError', $th->getMessage());
        }
    }


    /**
     * This function is used to delete a entry in student table
     * 
     * @param Illuminate\Http\Request
     * @return view
    */
    public function deleteStudentMarks(Request $request)
    {
        try {
            $request->validate([
                'id' => ['required'],
            ]);

            $marks = Student::find($request->id);
            $marks = $marks->delete();

            if ($marks) {
                return redirect()->back()->with('flashSuccess', 'Marks deleted successfully.');
            }
            else {
                return redirect()->back()->with('flashError', 'Failed to delete Marks.');
            }

        } catch (\Throwable $th) {
            Log::error('Controller Name :' . __METHOD__ . 'Error : ' . $th->getMessage());
            return redirect()->back()->with('flashError', $th->getMessage());
        }
    }
}
