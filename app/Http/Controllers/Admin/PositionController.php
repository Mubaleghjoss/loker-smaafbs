<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use App\Models\Position;
use Illuminate\Support\Str;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::query()
            ->withCount('applications')
            ->orderByDesc('is_active')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.positions.index', [
            'positions' => $positions,
        ]);
    }

    public function create()
    {
        return view('admin.positions.create');
    }

    public function store(StorePositionRequest $request)
    {
        $data = $request->validated();

        $slug = $data['slug'] ?? Str::slug($data['name']);
        $baseSlug = $slug;
        $i = 1;
        while (Position::query()->where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $i;
            $i++;
        }

        Position::query()->create([
            'name' => $data['name'],
            'slug' => $slug,
            'description' => $data['description'] ?? null,
            'requirements' => $data['requirements'] ?? null,
            'is_active' => (bool)($data['is_active'] ?? true),
            'sort_order' => (int)($data['sort_order'] ?? 0),
        ]);

        return redirect()->route('admin.positions.index')->with('success', 'Posisi berhasil dibuat.');
    }

    public function edit(Position $position)
    {
        return view('admin.positions.edit', [
            'position' => $position,
        ]);
    }

    public function update(UpdatePositionRequest $request, Position $position)
    {
        $data = $request->validated();

        $slug = $data['slug'] ?? Str::slug($data['name']);
        $baseSlug = $slug;
        $i = 1;
        while (Position::query()->where('slug', $slug)->where('id', '!=', $position->id)->exists()) {
            $slug = $baseSlug . '-' . $i;
            $i++;
        }

        $position->update([
            'name' => $data['name'],
            'slug' => $slug,
            'description' => $data['description'] ?? null,
            'requirements' => $data['requirements'] ?? null,
            'is_active' => (bool)($data['is_active'] ?? false),
            'sort_order' => (int)($data['sort_order'] ?? 0),
        ]);

        return redirect()->route('admin.positions.index')->with('success', 'Posisi berhasil diperbarui.');
    }

    public function destroy(Position $position)
    {
        $position->delete();

        return redirect()->route('admin.positions.index')->with('success', 'Posisi berhasil dihapus.');
    }

    public function toggleStatus(Position $position)
    {
        $position->update(['is_active' => !$position->is_active]);

        $status = $position->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.positions.index')->with('success', "Posisi \"{$position->name}\" berhasil {$status}.");
    }
}
