<?php

namespace App\Http\Controllers\Api;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Groups\StoreRequest;
use App\Http\Requests\Groups\UpdateRequest;
use App\Http\Resources\Settings\GroupResource;

class GroupController extends Controller
{
  public function index (Request $request) {
    $groups = Group::orderBy('name')->get();

    return GroupResource::collection($groups);
  }

  public function store (StoreRequest $request) {
    $group = new Group;
    $group->fill($request->all());

    return [
      'saved' => $group->save()
    ];
  }

  public function update (UpdateRequest $request, Group $group) {
    return [
      'updated' => $group->update($request->all())
    ];
  }

  public function destroy (Request $request, Group $group) {
    return [
      'deleted' => $group->delete()
    ];
  }
}
