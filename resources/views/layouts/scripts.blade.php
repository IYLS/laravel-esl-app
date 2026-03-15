{{-- jQuery y jQuery UI al final del body (no bloquean render inicial; ~330KB fuera del critical path) --}}
<script src="{{ asset('jquery/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('jquery/jquery-ui.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof $ !== 'undefined' && $.fn.draggable) {
        $('.modal[data-bs-backdrop="false"]').draggable({ handle: '.modal-header' });
    }

    // Prevenir que wheel dispare scroll cuando modal está abierto (fix flickering)
    document.addEventListener('wheel', function(e) {
        var modal = document.querySelector('.modal.show');
        if (!modal) return;
        var target = e.target;
        if (!target.closest('.modal') && !target.closest('.modal-backdrop')) return;
        var body = modal.querySelector('.modal-body');
        if (body && target.closest('.modal-body') && body.scrollHeight > body.clientHeight) {
            return;
        }
        e.preventDefault();
        e.stopPropagation();
    }, { passive: false, capture: true });
});
</script>

@if (session('success') || session('error'))
  @include('modals.exercises.message', [
      'message' => session('success') ?? session('error'),
      'type'    => session('success') ? 'success' : 'error'
  ])

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var el = document.getElementById('alert-modal');
      if (!el) return;

      // Bootstrap 5: use the native API
      var modal = bootstrap.Modal.getOrCreateInstance(el); // no double init
      if (!el.classList.contains('show')) modal.show();

      setTimeout(function(){ modal.hide(); }, 1500);
    });
  </script>
@endif

<!-- Lottie -->
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

{{-- Bootstrap ya está cargado en head.blade.php - NO duplicar (causa que collapse/dropdown no se replieguen) --}}

{{-- Inicializar popovers de Bootstrap --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.forEach(function (popoverTriggerEl) {
            new bootstrap.Popover(popoverTriggerEl);
        });
    });
</script>

{{-- Forum pickers: reacciones y emoji --}}
<script>
(function() {
    function closeAllForumPickers() {
        document.querySelectorAll('.forum-picker-popover.is-open').forEach(function(el) {
            el.classList.remove('is-open');
            el.setAttribute('aria-hidden', 'true');
        });
    }
    function positionPopover(popover, trigger, alignEnd) {
        var rect = trigger.getBoundingClientRect();
        var spaceAbove = rect.top, spaceBelow = window.innerHeight - rect.bottom;
        if (alignEnd) {
            popover.style.right = (window.innerWidth - rect.right) + 'px';
            popover.style.left = 'auto';
        } else {
            popover.style.left = rect.left + 'px';
            popover.style.right = 'auto';
        }
        popover.style.width = 'auto';
        if (spaceBelow >= 120 || spaceAbove < spaceBelow) {
            popover.style.top = 'auto';
            popover.style.bottom = (window.innerHeight - rect.top + 4) + 'px';
        } else {
            popover.style.top = (rect.bottom + 4) + 'px';
            popover.style.bottom = 'auto';
        }
    }
    function initReactionPickers() {
        document.querySelectorAll('.reaction-picker-wrapper:not([data-reaction-init])').forEach(function(wrapper) {
            wrapper.dataset.reactionInit = '1';
            var route = wrapper.dataset.route, reactionsList = wrapper.querySelector('.reactions-list');
            var trigger = wrapper.querySelector('.reaction-add-btn'), popover = wrapper.querySelector('.reaction-dropdown');
            if (!trigger || !popover) return;
            function sendReaction(emoji, btn) {
                if (btn) btn.classList.add('loading');
                var fd = new FormData();
                fd.append('emoji', emoji);
                fd.append('_token', document.querySelector('input[name="_token"]')?.value);
                fetch(route, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }, body: fd })
                    .then(function(r) { if (btn) btn.classList.remove('loading'); return r.ok ? r.json() : null; })
                    .then(function(data) {
                        if (!data) return;
                        reactionsList.innerHTML = '';
                        var reactions = data.reactions;
                        if (typeof reactions === 'object' && !Array.isArray(reactions)) reactions = Object.values(reactions);
                        (reactions || []).forEach(function(r) {
                            var b = document.createElement('button');
                            b.type = 'button';
                            b.className = 'reaction-btn' + (r.user_reacted ? ' reacted' : '');
                            b.dataset.emoji = r.emoji;
                            b.title = (r.users || []).join(', ');
                            b.innerHTML = '<span class="reaction-emoji">' + r.emoji + '</span>' + (r.count > 1 ? '<span class="reaction-count">' + r.count + '</span>' : '');
                            b.addEventListener('click', function(e) { e.preventDefault(); sendReaction(this.dataset.emoji, this); });
                            reactionsList.appendChild(b);
                        });
                    });
            }
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeAllForumPickers();
                if (popover.classList.contains('is-open')) {
                    popover.classList.remove('is-open');
                    popover.setAttribute('aria-hidden', 'true');
                } else {
                    positionPopover(popover, trigger, false);
                    popover.classList.add('is-open');
                    popover.setAttribute('aria-hidden', 'false');
                }
            });
            popover.querySelectorAll('.reaction-emoji-add').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    popover.classList.remove('is-open');
                    popover.setAttribute('aria-hidden', 'true');
                    sendReaction(this.dataset.emoji);
                });
            });
            wrapper.querySelectorAll('.reaction-btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) { e.preventDefault(); sendReaction(this.dataset.emoji, this); });
            });
        });
    }
    function initEmojiPickers() {
        document.querySelectorAll('.emoji-picker-wrapper:not([data-emoji-init])').forEach(function(wrapper) {
            wrapper.dataset.emojiInit = '1';
            var trigger = wrapper.querySelector('.emoji-trigger'), popover = wrapper.querySelector('.emoji-picker-dropdown');
            var targetId = wrapper.dataset.target || 'content';
            if (!trigger || !popover) return;
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeAllForumPickers();
                if (popover.classList.contains('is-open')) {
                    popover.classList.remove('is-open');
                } else {
                    positionPopover(popover, trigger, wrapper.dataset.align === 'end');
                    popover.classList.add('is-open');
                }
            });
            popover.querySelectorAll('.emoji-btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    var ta = document.getElementById(targetId);
                    if (ta) {
                        var emoji = this.dataset.emoji, start = ta.selectionStart, end = ta.selectionEnd;
                        ta.value = ta.value.substring(0, start) + emoji + ta.value.substring(end);
                        ta.selectionStart = ta.selectionEnd = start + emoji.length;
                        ta.focus();
                    }
                    popover.classList.remove('is-open');
                });
            });
        });
    }
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.forum-picker-popover') && !e.target.closest('.reaction-add-btn') && !e.target.closest('.emoji-trigger')) {
            closeAllForumPickers();
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
        initReactionPickers();
        initEmojiPickers();
    });
    if (document.readyState !== 'loading') {
        initReactionPickers();
        initEmojiPickers();
    }
})();
</script>