<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ComicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comics = Comic::paginate(6);
        return view('comics.index', compact('comics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('comics.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate_form($request);

        $data = $request->all();

        $comic = new Comic();
        // $comic->title = $data['title'];
        // $comic->sale_date = $data['sale_date'];
        // $comic->price = $data['price'];
        // $comic->thumb = $data['thumb'];
        // $comic->type = $data['type'];
        // $comic->series = $data['series'];
        // $comic->description = $data['description'];

        $comic->fill($data);

        $comic->save();

        return redirect()->route('comics.show', $comic)->with('message-class', 'alert-success ')->with('message', 'fumetto aggiunto correttamente ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comic  $comic
     * @return \Illuminate\Http\Response
     */
    public function show(Comic $comic)
    {
        return view('comics.show', compact('comic'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comic  $comic
     * @return \Illuminate\Http\Response
     */
    public function edit(Comic $comic)
    {
        return view('comics.edit', compact('comic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comic  $comic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comic $comic)
    {
        $data = $request->all();

        $comic->update($data);

        return redirect()->route('comics.show', $comic)->with('message-class', 'alert-success ')->with('message', 'fumetto modificato correttamente ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comic  $comic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comic $comic)
    {
        $comic->delete();
        return redirect()->route('comics.index')->with('message-class', 'alert-danger ')->with('message', 'fumetto eliminato ');
    }

    private function validate_form($request)
    {
        $request->validate(
            [
                'title' => 'required|min:5|max:20',
                'sale_date' => 'required',
                'price' => 'required',
                'thumb' => '',
                'type' => ['required', Rule::in(['comic book', 'graphic novel'])],
                'series' => 'required',
                'description' => '',
            ],
            [
                'title.required' => 'il campo è obbligatorio',
                'title.min' => 'il campo è troppo corto',
                'title.max' => 'il campo è troppo lungo',
            ],
        );
    }
}
