<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function index()
    {
        $teamMembers = TeamMember::orderBy('order')->get();
        return view('admin.team-members.index', compact('teamMembers'));
    }

    public function create()
    {
        return view('admin.team-members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/team'), $imageName);
            $imagePath = 'uploads/team/' . $imageName;
        }

        TeamMember::create([
            'name' => $request->name,
            'role' => $request->role,
            'image' => $imagePath,
            'facebook_url' => $request->facebook_url,
            'twitter_url' => $request->twitter_url,
            'instagram_url' => $request->instagram_url,
            'is_active' => true,
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.team-members.index')->with('success', 'Team member created successfully!');
    }

    public function edit(TeamMember $team_member)
    {
        return view('admin.team-members.edit', compact('team_member'));
    }

    public function update(Request $request, TeamMember $team_member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'role' => $request->role,
            'facebook_url' => $request->facebook_url,
            'twitter_url' => $request->twitter_url,
            'instagram_url' => $request->instagram_url,
            'is_active' => true,
            'order' => $request->order ?? 0,
        ];

        if ($request->hasFile('image')) {
            if ($team_member->image && file_exists(public_path($team_member->image))) {
                unlink(public_path($team_member->image));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/team'), $imageName);
            $data['image'] = 'uploads/team/' . $imageName;
        }

        $team_member->update($data);
        return redirect()->route('admin.team-members.index')->with('success', 'Team member updated successfully!');
    }

    public function destroy(TeamMember $team_member)
    {
        if ($team_member->image && file_exists(public_path($team_member->image))) {
            unlink(public_path($team_member->image));
        }
        $team_member->delete();
        return redirect()->route('admin.team-members.index')->with('success', 'Team member deleted successfully!');
    }

    public function show(string $id) {}
}
