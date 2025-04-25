let currentMonth = new Date().getMonth() + 1;
function renderTimeline(m) {
  const daysInMonth = [31,28,31,30,31,30,31,31,30,31,30,31][m-1];
  const tl = document.getElementById('timeline');
  const lg = document.getElementById('legend');
  tl.style.gridTemplateColumns = `120px repeat(${daysInMonth},40px)`;
  tl.innerHTML = lg.innerHTML = '';

  // header
  let hdr = '<div class="timeline-header"><div></div>';
  for(let d=1; d<=daysInMonth; d++){
    hdr += `<div>${d}</div>`;
  }
  hdr += '</div>';
  tl.insertAdjacentHTML('beforeend', hdr);

  // legend
  vehicles.forEach(v=>{
    lg.insertAdjacentHTML('beforeend',
      `<div class="legend-item"><span class="color-box violation"></span>${v}</div>`
    );
  });

  // rows
  vehicles.forEach(v=>{
    tl.insertAdjacentHTML('beforeend', `<div>${v}</div>`);
    (tasksByMonth[m]||[]).filter(t=>t.plate===v)
      .forEach(t=>{
        const div = document.createElement('div');
        div.className = `task ${t.type}`;
        div.style.gridColumn = `${t.day+1} / span ${t.span}`;
        div.textContent = t.label;
        tl.appendChild(div);
      });
  });
  document.getElementById('month-label').textContent = `${m}月`;
}

function changeMonth(offset){
  const m = currentMonth + offset;
  if(m>=1 && m<=12){
    currentMonth = m;
    renderTimeline(m);
  }
}

document.addEventListener('DOMContentLoaded', () => renderTimeline(currentMonth));
