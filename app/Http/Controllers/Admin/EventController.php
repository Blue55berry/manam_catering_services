<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('order')->get();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $categories = Event::getCategories();
        return view('admin.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'category' => 'required|in:wedding,corporate,cocktail,buffet,celebration,social',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/events'), $imageName);
            $imagePath = 'uploads/events/' . $imageName;
        }

        Event::create([
            'title' => $request->title,
            'category' => $request->category,
            'image' => $imagePath,
            'is_active' => true,
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully!');
    }

    public function edit(Event $event)
    {
        $categories = Event::getCategories();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'category' => 'required|in:wedding,corporate,cocktail,buffet,celebration,social',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'category' => $request->category,
            'is_active' => true,
            'order' => $request->order ?? 0,
        ];

        if ($request->hasFile('image')) {
            if ($event->image && file_exists(public_path($event->image))) {
                unlink(public_path($event->image));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/events'), $imageName);
            $data['image'] = 'uploads/events/' . $imageName;
        }

        $event->update($data);
        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        if ($event->image && file_exists(public_path($event->image))) {
            unlink(public_path($event->image));
        }
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully!');
    }
}
