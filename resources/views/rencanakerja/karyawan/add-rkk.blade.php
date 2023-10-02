@include('template.header')


<body>
    <header>
        <div class="bg-prima btn-header">
            <h2 class="text-sec pt-1">
                Rencana Kerja
            </h2>
        </div>
    </header>
    <div class="container mt-2">
        <form action="">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Perihal">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Lokasi">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Waktu Pelaksanaan">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Target Penyelesaian">
            </div>
            <div class="form-group">
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="Keterangan"></textarea>
            </div>
            <div class="form-group">
                <label for="fileInput" class="d-flex align-items-center">
                    <input type="text" class="form-control" id="fileLabel" value="Lampiran" disabled>
                    <input type="file" class="form-control-file" id="fileInput" style="display: none;"
                        onchange="updateFileLabel()">
                    <button class="btn btn-secondary ml-2" id="uploadButton"
                        onclick="document.getElementById('fileInput').click();">Upload</button>
                </label>
            </div>
            <div class="form-group">
                <select class="form-control form-select">
                    <option selected>--Pilih Prioritas--</option>
                    <option value="1">Penting</option>
                    <option value="2">Normal</option>
                    <option value="3">Mendesak</option>
                </select>

            </div>
            <div class="form-group">
                <button class="btn btn-block bg-prima text-sec">Submit</button>
            </div>
        </form>
    </div>
</body>

@include('template.bottomNav')
@include('template.footer')

</html>
