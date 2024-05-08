<form id="invitationForm" action="proses_form.php" method="post">
  <label for="invitationType">Tipe Undangan:</label>
  <select id="invitationType" name="invitationType">
      <option value="personal">Personal</option>
      <option value="group">Berkelompok</option>
  </select><br><br>

  <div id="personalGuest" style="display: none;">
      <label for="guestName">Nama Pengunjung:</label>
      <input type="text" id="guestName" name="guestName"><br><br>
  </div>

  <div id="groupGuest" style="display: none;">
      <label for="groupMember">Anggota Kelompok:</label>
      <input type="text" id="groupMember" name="groupMember"><br><br>
      <button type="button" id="addMember">Tambah Anggota</button>
  </div>

  <button type="submit">Submit</button>
</form>

<script>
  document.getElementById('invitationType').addEventListener('change', function() {
    var personalDiv = document.getElementById('personalGuest');
    var groupDiv = document.getElementById('groupGuest');

    if (this.value === 'personal') {
        personalDiv.style.display = 'block';
        groupDiv.style.display = 'none';
    } else if (this.value === 'group') {
        personalDiv.style.display = 'none';
        groupDiv.style.display = 'block';
    }
});

document.getElementById('addMember').addEventListener('click', function() {
    var groupMemberInput = document.createElement('input');
    groupMemberInput.type = 'text';
    groupMemberInput.name = 'groupMember[]'; // Use array for multiple members
    groupMemberInput.placeholder = 'Nama Pengunjung';
    document.getElementById('groupGuest').appendChild(groupMemberInput);
    document.getElementById('groupGuest').appendChild(document.createElement('br'));
});

</script>