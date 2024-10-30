<!DOCTYPE html>
<html>
<head>
    <title>Buat Undangan</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Buat Undangan</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('janji_temu.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Subject</label>
                <input type="text" name="subject" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Keperluan</label>
                <select name="keperluan" class="form-control" id="keperluan" required>
                    <option value="Pribadi">Pribadi</option>
                    <option value="Pekerjaan">Pekerjaan</option>
                </select>
            </div>
            <div class="form-group">
                <label>Kunjungan Dari</label>
                <input type="text" name="kunjungan_dari" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Waktu Temu</label>
                <input type="datetime-local" name="waktu_temu" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Waktu Kembali</label>
                <input type="datetime-local" name="waktu_kembali" class="form-control">
            </div>
            <div class="form-group">
                <label>Host ID</label>
                <select name="host_id" class="form-control" required>
                    @foreach($hosts as $host)
                        <option value="{{ $host->id }}">{{ $host->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <input type="text" name="keterangan" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Type</label>
                <select name="type" class="form-control" id="invitationType" required>
                    <option value="personal">Personal</option>
                    <option value="group">Group</option>
                </select>
            </div>
            <div id="groupMembers" style="display: none;">
                <h4>Group Members</h4>
                <div class="form-group group-member">
                    <label>Name</label>
                    <input type="text" name="group_members[0][name]" class="form-control">
                    <label>Email</label>
                    <input type="email" name="group_members[0][email]" class="form-control">
                    <label>Phone</label>
                    <input type="text" name="group_members[0][phone]" class="form-control">
                    <button type="button" class="btn btn-danger remove-member">Remove</button>
                </div>
                <button type="button" id="addGroupMember" class="btn btn-secondary">Add Member</button>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        $(document).ready(function () {
            $('#invitationType').change(function () {
                if ($(this).val() === 'group') {
                    $('#groupMembers').show();
                } else {
                    $('#groupMembers').hide();
                }
            });

            let memberIndex = 1;
            $('#addGroupMember').click(function () {
                const newMember = $('.group-member:first').clone().removeAttr('id');
                newMember.find('input').each(function () {
                    const name = $(this).attr('name');
                    const newName = name.replace(/\[\d+\]/, `[${memberIndex}]`);
                    $(this).attr('name', newName).val('');
                });
                newMember.appendTo('#groupMembers');
                memberIndex++;
            });

            $(document).on('click', '.remove-member', function () {
                $(this).closest('.group-member').remove();
            });
        });
    </script>   
</body>
</html>
