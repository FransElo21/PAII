<form method="POST" action="">
    @csrf
    @method('POST')
    
    <label for="waktu">Waktu:</label>
    <input type="text" name="waktu" value="{{ $undangan->waktu_temu }}">
    
    <label for="lokasi">Lokasi:</label>
    <select name="lokasi">
        @foreach($lokasis as $lokasi)
            <option value="{{ $lokasi->id }}">
                {{ $lokasi->ruangan }} {{ $lokasi->lantai }}
            </option>
        @endforeach
    </select>

    
    <button type="submit">Simpan Perubahan</button>
</form>
