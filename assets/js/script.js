const menuToggle = document.querySelector('.menu-toggle');
const siteNav = document.getElementById('site-nav');

if (menuToggle && siteNav) {
  menuToggle.addEventListener('click', () => {
    const isOpen = siteNav.classList.toggle('open');
    menuToggle.setAttribute('aria-expanded', String(isOpen));
  });
}

const activityCards = document.querySelectorAll('.activity-card');
const modal = document.getElementById('activityModal');
const modalTitle = document.getElementById('activityModalTitle');
const modalDescription = document.getElementById('activityModalDescription');
const modalDate = document.getElementById('activityModalDate');
const modalTime = document.getElementById('activityModalTime');

const closeModal = () => {
  if (!modal) return;

  modal.classList.remove('is-open');
  modal.setAttribute('aria-hidden', 'true');
  modal.setAttribute('hidden', '');
  document.body.classList.remove('modal-open');
};

const openModal = (card) => {
  if (!modal || !modalTitle || !modalDescription || !modalDate || !modalTime) return;

  modalTitle.textContent = card.dataset.name || 'Activiteit';
  modalDescription.textContent = card.dataset.description || 'Meer informatie volgt.';
  modalDate.textContent = card.dataset.date || 'Binnenkort';
  modalTime.textContent = card.dataset.time || '—';

  modal.classList.add('is-open');
  modal.setAttribute('aria-hidden', 'false');
  modal.removeAttribute('hidden');
  document.body.classList.add('modal-open');
};

activityCards.forEach((card) => {
  const handleOpen = () => openModal(card);

  card.addEventListener('click', handleOpen);
  card.addEventListener('keydown', (event) => {
    if (event.key === 'Enter' || event.key === ' ') {
      event.preventDefault();
      handleOpen();
    }
  });
});

document.querySelectorAll('[data-close-modal]').forEach((element) => {
  element.addEventListener('click', closeModal);
});

document.addEventListener('keydown', (event) => {
  if (event.key === 'Escape') {
    closeModal();
  }
});

if (modal) {
  modal.addEventListener('click', (event) => {
    if (event.target === modal) {
      closeModal();
    }
  });
}
