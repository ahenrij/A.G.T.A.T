<?php

namespace App\Http\Controllers;

use App\Repositories\ZoneRepository;
use App\User;
use App\Zone;
use Illuminate\Http\Request;

use App\Http\Requests;

class ZoneController extends Controller
{
    protected $zone;
    protected $zoneRepository;

    public function __construct(ZoneRepository $zoneRepository)
    {
        $this->middleware('auth');
        $this->middleware('admin', ['except' => ['saveByAjax']]);
        $this->middleware('ajax', ['only' => ['saveByAjax']]);
        $this->zoneRepository = $zoneRepository;
    }

    public function index()
    {
        $zones = Zone::all();
        return view('zones.index', compact('zones'));
    }

    public function create()
    {
        return view('zones.index');
    }

    public function store(Requests\ZoneCreateRequest $request)
    {
        $zone = $this->zoneRepository->store($request->all());
        save_trace("Enregistrement de la zone " . $zone->libelle, LOG_INFORMATION);
        return redirect('zone')->withOk('La zone ' . $zone->libelle . ' a été créée.');
    }

    public function saveByAjax()
    {
        $inputs = request();
        $zone = new Zone();
        $zone->libelle = $inputs['libelle'];
        if ($zone->save()) {
            save_trace("Enregistrement de la zone " . $zone->libelle, LOG_INFORMATION);
            return response()->json(['response' => 'ok']);
        } else {
            return response()->json(['response' => 'failure']);
        }
    }

    public function show($id)
    {
        $zone = $this->zoneRepository->getById($id);
        return view('zones.show', compact('zone'));
    }

    public function edit($id)
    {
        $zone = $this->zoneRepository->getById($id);
        return view('zones.edit', compact('zone'));
    }

    public function update(Requests\ZoneUpdateRequest $request, $id)
    {
        $this->zoneRepository->update($id, $request->all());
        save_trace("Modification de la zone " . $this->zoneRepository->getById($id)->libelle, LOG_MODIFICATION);
        return redirect('zone')->withOk('La zone ' . $request->input('libelle') . ' a été modifiée.');
    }

    public function destroy($id)
    {
        $zone = $this->zoneRepository->getById($id);

        if ((bool)($zone->titres()->first())) { // La zone est liée à plusieurs titres
            return redirect('zone')->withOk('Suppression impossible : La zone ' . $zone->libelle . ' est liée à des titres');
        }

        save_trace("Suppression de la zone " . $zone->libelle, LOG_SUPPRESSION);
        $this->zoneRepository->destroy($id);
        return back();
    }
}
