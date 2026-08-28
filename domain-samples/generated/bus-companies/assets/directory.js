
document.querySelectorAll('.region-head').forEach(function(head){
  head.addEventListener('click', function(){
    head.closest('.region-group').classList.toggle('open');
  });
});

var currentPrefLabel = document.getElementById('currentPref');
var companyList = document.getElementById('companyList');
var emptyNote = document.getElementById('emptyNote');
var allPrefButtons = document.querySelectorAll('#regionMenu [data-pref]');

allPrefButtons.forEach(function(btn){
  btn.addEventListener('click', function(){
    allPrefButtons.forEach(function(b){ b.classList.remove('active'); });
    btn.classList.add('active');

    var pref = btn.dataset.pref;
    currentPrefLabel.textContent = pref + 'の事業者一覧';
    companyList.style.display = '';

    var visibleCount = 0;
    companyList.querySelectorAll('.company-card').forEach(function(card){
      var show = (card.dataset.pref === pref);
      card.style.display = show ? '' : 'none';
      if(show) visibleCount++;
    });
    emptyNote.style.display = visibleCount === 0 ? '' : 'none';
  });
});
