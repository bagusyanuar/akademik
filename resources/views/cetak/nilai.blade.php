@extends('cetak.index')

@section('content')
    <div class="text-center f-bold report-title">LAPORAN HASIL BELAJAR</div>
    <div class="text-center f-bold report-title"style="font-size: 16px">MA Al-MANSHUR POPONGAN KLATEN</div>
    <div class="text-center">Popongan, RT.03/RW.03, Tegalgondo</div>
    <br/>
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
    <table id="my-table" class="table display">
        <thead>
        <tr>
            <th width="5%" class="text-center">#</th>
            <th width="85%">Mata Pelajaran</th>
            <th width="10%" class="text-center">Nilai</th>
        </tr>
        </thead>
        <tbody>
        @foreach($pelajaran as $v)
            <tr>
                <td class="text-center">{{ $loop->index + 1 }}</td>
                <td>{{ $v->mataPelajaran->nama }}</td>
                <td class="text-center">{{ $v->nilai->nilai }}</td>
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
        </tbody>
    </table>
@endsection
