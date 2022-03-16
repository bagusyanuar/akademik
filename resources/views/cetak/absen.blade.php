@extends('cetak.index')

@section('content')

    <div class="row">
        <div class="col-xs-6">
            <table style="width: 100%">
                <tr>
                    <td width="30%">Nama Siswa</td>
                    <td width="5%%"></td>
                    <td width="65%">: {{ $siswa->nama }}</td>
                </tr>
            </table>
        </div>
        <div class="col-xs-5">
            <table style="width: 100%">
                <tr>
                    <td width="40%">Tahun Pelajaran</td>
                    <td width="5%"></td>
                    <td width="55%">: {{ $periode->nama }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <table style="width: 100%">
                <tr>
                    <td width="30%">No. Induk</td>
                    <td width="5%%"></td>
                    <td width="65%">: {{ $siswa->nis }}</td>
                </tr>
            </table>
        </div>
        <div class="col-xs-5">
            <table style="width: 100%">
                <tr>
                    <td width="40%">Semester</td>
                    <td width="5%"></td>
                    <td width="55%">: {{ $semester }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <table style="width: 100%">
                <tr>
                    <td width="30%">Kelas</td>
                    <td width="5%%"></td>
                    <td width="65%">: {{ $kelas->nama }}</td>
                </tr>
            </table>
        </div>
    </div>
    <hr>
    <p style="font-weight: bold">ABSENSI SISWA</p>
    <table id="my-table" class="table display">
        <thead>
        <tr>
            <th width="5%" class="text-center">#</th>
            <th width="15%">Tanggal</th>
            <th width="20%" class="text-center">Absen</th>
            <th width="60%" class="text-center">Keterangan</th>
        </tr>
        </thead>
        <tbody>
        @foreach($absensi as $v)
            <tr>
                <td class="text-center">{{ $loop->index + 1 }}</td>
                <td>{{ $v->tanggal }}</td>
                <td>{{ $v->nilaiabsen !== null ? $v->nilaiabsen->nilai : 'Belum Di Absen' }}</td>
                <td class="text-center">{{ $v->nilaiabsen !== null ? $v->nilaiabsen->keterangan : '-' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <br/>
    <p class="f-bold">KEHADIRAN</p>
    <table id="my-table2" class="table display">
        <thead>
        <tr>
            <th width="5%" class="text-center">#</th>
            <th width="80%">KEHADIRAN</th>
            <th width="15%" class="text-center">LAMA HARI</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="text-center">1</td>
            <td>Masuk</td>
            <td class="text-center">{{ $masuk }}</td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td>Ijin</td>
            <td class="text-center">{{ $ijin }}</td>
        </tr>
        <tr>
            <td class="text-center">3</td>
            <td>Alpha</td>
            <td class="text-center">{{ $alpha }}</td>
        </tr>
        <tr>
            <td class="text-center">3</td>
            <td>Tidak Di Absen</td>
            <td class="text-center">{{ $kosong }}</td>
        </tr>
        </tbody>
    </table>
    <div class="row">
        <div class="col-xs-8"></div>
        <div class="col-xs-3">
            <div class="text-center">
                <p class="text-center">Klaten, {{ $tanggal }}</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-3">
            <div class="text-center">
                <p>Orang Tua</p>
            </div>
        </div>
        <div class="col-xs-5"></div>
        <div class="col-xs-3">
            <div class="text-center">
                <p class="text-center">Wali Kelas,</p>
            </div>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-xs-3">
            <div class="text-center">
                <p>(.............)</p>
            </div>
        </div>
        <div class="col-xs-5"></div>
        <div class="col-xs-3">
            <div class="text-center">
                <p class="text-center">{{ $guru->nama }}</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-3">
        </div>
        <div class="col-xs-5">
            <div class="text-center">
                <p class="text-center">Mengetahui,</p>
                <p class="text-center">Kepala Sekolah</p>
            </div>
        </div>
        <div class="col-xs-3">
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-xs-3">
        </div>
        <div class="col-xs-5">
            <div class="text-center">
                <p class="text-center">Drs. Bambang Setyo, M.Pd</p>
            </div>
        </div>
        <div class="col-xs-3">
        </div>
    </div>
@endsection
