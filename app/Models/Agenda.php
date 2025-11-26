<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'agendas';

    protected $fillable = [
        'tanggal',
        'waktu',
        'agenda',
        'tempat',
        'id_surat',
        'id_jabatan',
        'id_pakaian',
        'id_user',
        'id_perangkat_daerah',
        'id_misi',
        'id_program',
        'resume',
    ];

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu' => 'datetime',
    ];

    // ==========================================
    // RELATIONSHIPS
    // ==========================================

    /**
     * Relasi ke Surat (Many to One)
     * Setiap agenda terkait dengan satu surat
     */
    public function surat()
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }

    /**
     * Relasi ke Jabatan (Many to One)
     * Setiap agenda ditujukan untuk satu jabatan
     */
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }

    /**
     * Relasi ke Pakaian (Many to One)
     * Setiap agenda memiliki ketentuan pakaian
     */
    public function pakaian()
    {
        return $this->belongsTo(Pakaian::class, 'id_pakaian');
    }

    /**
     * Relasi ke User (Many to One)
     * User yang membuat/input agenda
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Relasi ke Perangkat Daerah (Many to One)
     * Perangkat daerah yang bertanggung jawab atas agenda
     */
    public function perangkatDaerah()
    {
        return $this->belongsTo(PerangkatDaerah::class, 'id_perangkat_daerah');
    }

    /**
     * Relasi ke Misi (Many to One)
     * Agenda terkait dengan misi tertentu
     */
    public function misi()
    {
        return $this->belongsTo(Misi::class, 'id_misi');
    }

    /**
     * Relasi ke Program (Many to One)
     * Agenda terkait dengan program tertentu
     */
    public function program()
    {
        return $this->belongsTo(Program::class, 'id_program');
    }

    /**
     * Relasi ke Photos (One to Many)
     * Agenda dapat memiliki banyak foto
     */
    public function photos()
    {
        return $this->hasMany(AgendaPhoto::class, 'agenda_id');
    }

    // ==========================================
    // SCOPES
    // ==========================================

    /**
     * Scope untuk filter agenda berdasarkan tanggal
     */
    public function scopeByDate($query, $date)
    {
        return $query->whereDate('tanggal', $date);
    }

    /**
     * Scope untuk filter agenda hari ini
     */
    public function scopeToday($query)
    {
        return $query->whereDate('tanggal', now());
    }

    /**
     * Scope untuk filter agenda minggu ini
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('tanggal', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    /**
     * Scope untuk filter agenda bulan ini
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year);
    }

    /**
     * Scope untuk filter berdasarkan perangkat daerah
     */
    public function scopeByPerangkatDaerah($query, $idPerangkatDaerah)
    {
        return $query->where('id_perangkat_daerah', $idPerangkatDaerah);
    }

    /**
     * Scope untuk filter berdasarkan jabatan
     */
    public function scopeByJabatan($query, $idJabatan)
    {
        return $query->where('id_jabatan', $idJabatan);
    }

    /**
     * Scope untuk urutkan berdasarkan prioritas jabatan dan waktu
     */
    public function scopeOrderedByPriority($query)
    {
        return $query->join('jabatans', 'agendas.id_jabatan', '=', 'jabatans.id')
            ->orderBy('jabatans.prioritas', 'asc')
            ->orderBy('agendas.waktu', 'asc')
            ->select('agendas.*');
    }

    // ==========================================
    // ACCESSORS & MUTATORS
    // ==========================================

    /**
     * Accessor untuk format tanggal Indonesia
     */
    public function getTanggalFormatAttribute()
    {
        return \Carbon\Carbon::parse($this->tanggal)->translatedFormat('l, d F Y');
    }

    /**
     * Accessor untuk format waktu
     */
    public function getWaktuFormatAttribute()
    {
        return \Carbon\Carbon::parse($this->waktu)->format('H:i');
    }

    /**
     * Accessor untuk nama jabatan
     */
    public function getJabatanNameAttribute()
    {
        return $this->jabatan->jabatan ?? '-';
    }

    /**
     * Accessor untuk nama perangkat daerah
     */
    public function getPerangkatDaerahNameAttribute()
    {
        return $this->perangkatDaerah->singkatan ?? '-';
    }
}
