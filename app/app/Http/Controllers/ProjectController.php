<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProjectController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::user()->id);
        if ($user->group_id == 1) {
            $projects = Project::join('users', 'projects.user_id', '=', 'users.id')
                ->get(['projects.name', 'projects.id', 'users.name as user_name']);
        } else {
            $projects = Project::join('users', 'projects.user_id', '=', 'users.id')
                ->where('projects.user_id', '=', $user->id)
                ->get(['projects.name', 'projects.id', 'users.name as user_name']);
        };

        return view('projects', [
            'projects' => $projects
        ]);
    }

    public function add(Request $request)
    {
        if (!$request->name) return Redirect::back()->withErrors(['msg' => 'Введите название проекта']);
        $project = new Project();
        $project->name = $request->name;
        $project->user_id = Auth::user()->id;

        if ($project->save()) {
            return Redirect::back()->with(['success' => 'Проект успешно добавлен']);
        } else {
            return Redirect::back()->withErrors(['msg' => 'Упс! Что то пошло не так']);
        }
    }

    public function edit($id)
    {
        $project = Project::find($id);
        return view('project_edit', [
            'project' => $project
        ]);
    }

    public function postEdit(Request $request, $id)
    {
        $project = Project::find($id);
        $project->name = $request->name;

        if ($project->save()) {
            return Redirect::route('projects')->with(['success' => 'Проект успешно изменен']);
        } else {
            return Redirect::route('projects')->withErrors(['msg' => 'Упс! Что то пошло не так']);
        }
    }

    public function del($id)
    {
        $project = Project::find($id);
        if ($project->delete()) {
            return Redirect::back()->with(['success' => 'Проект успешно удален']);
        } else {
            return Redirect::back()->withErrors(['msg' => 'Упс! Что то пошло не так']);
        }
    }
}
