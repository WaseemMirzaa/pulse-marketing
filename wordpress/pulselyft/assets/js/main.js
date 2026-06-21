/**
 * PulseLyft theme front-end behavior.
 *
 * - Colour theme toggle (persisted, system-aware, no-flash)
 * - Sticky/shrinking header, scroll progress bar, scrollspy, back-to-top
 * - Staggered scroll-reveal animations (IntersectionObserver)
 * - Animated stat counters
 * - FAQ single-open accordion
 * - Mobile nav toggle
 * - Floating chat assistant (REST endpoint or external API)
 *
 * @package PulseLyft
 */
(function () {
	'use strict';

	var cfg = window.PulseLyftCfg || {};
	var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	function ready(fn) {
		if (document.readyState !== 'loading') { fn(); }
		else { document.addEventListener('DOMContentLoaded', fn); }
	}

	/* ------------------------------------------------------------ Colour theme */
	function initTheme() {
		var toggles = document.querySelectorAll('.pl-theme-toggle');
		var meta = document.querySelector('meta[name="theme-color"]');

		function apply(theme, persist) {
			if (theme === 'dark') {
				document.documentElement.setAttribute('data-theme', 'dark');
			} else {
				document.documentElement.removeAttribute('data-theme');
			}
			if (meta) { meta.setAttribute('content', theme === 'dark' ? '#0a0a0b' : '#0f0f10'); }
			toggles.forEach(function (t) { t.setAttribute('aria-pressed', theme === 'dark' ? 'true' : 'false'); });
			if (persist) { try { localStorage.setItem('pl-theme', theme); } catch (e) {} }
		}

		toggles.forEach(function (t) {
			t.addEventListener('click', function () {
				var isDark = document.documentElement.getAttribute('data-theme') === 'dark';
				apply(isDark ? 'light' : 'dark', true);
			});
		});

		apply(document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light', false);
	}

	/* -------------------------------------------------------------- Mobile nav */
	function initNav() {
		var burger = document.getElementById('pl-burger');
		var menu = document.getElementById('pl-mobile-nav');
		if (!burger || !menu) { return; }

		function close() {
			menu.classList.remove('is-open');
			burger.setAttribute('aria-expanded', 'false');
		}
		burger.addEventListener('click', function () {
			var open = menu.classList.toggle('is-open');
			burger.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
		menu.querySelectorAll('a').forEach(function (a) { a.addEventListener('click', close); });
		window.addEventListener('resize', function () { if (window.innerWidth >= 880) { close(); } });
	}

	/* ------------------------------------ Header state / progress / spy / totop */
	function initScroll() {
		var header = document.getElementById('pl-header');
		var progress = document.getElementById('pl-progress');
		var totop = document.getElementById('pl-totop');
		var navLinks = Array.prototype.slice.call(document.querySelectorAll('.pl-nav__link'));

		var sections = navLinks.map(function (link) {
			var href = link.getAttribute('href') || '';
			var i = href.indexOf('#');
			if (i < 0) { return null; }
			var id = href.slice(i + 1);
			var el = id ? document.getElementById(id) : null;
			return el ? { link: link, el: el } : null;
		}).filter(Boolean);

		var ticking = false;
		function onScroll() {
			var y = window.scrollY || window.pageYOffset || 0;

			if (header) { header.classList.toggle('is-scrolled', y > 12); }

			if (progress) {
				var h = document.documentElement.scrollHeight - window.innerHeight;
				progress.style.width = (h > 0 ? (y / h) * 100 : 0) + '%';
			}

			if (totop) { totop.classList.toggle('is-visible', y > 600); }

			if (sections.length) {
				var pos = y + window.innerHeight * 0.3;
				var active = null;
				sections.forEach(function (s) { if (s.el.offsetTop <= pos) { active = s; } });
				navLinks.forEach(function (l) { l.classList.remove('is-active'); });
				if (active) { active.link.classList.add('is-active'); }
			}
			ticking = false;
		}
		function request() { if (!ticking) { ticking = true; window.requestAnimationFrame(onScroll); } }

		window.addEventListener('scroll', request, { passive: true });
		window.addEventListener('resize', request, { passive: true });
		onScroll();

		if (totop) {
			totop.addEventListener('click', function () {
				window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' });
			});
		}
	}

	/* ------------------------------------------------------- Scroll reveals */
	function initReveals() {
		var els = document.querySelectorAll('.pl-reveal');
		if (!els.length) { return; }

		if (reduceMotion || !('IntersectionObserver' in window)) {
			els.forEach(function (el) { el.classList.add('is-visible'); });
			return;
		}

		// Stagger each element among its reveal-siblings for a cascade effect.
		els.forEach(function (el) {
			var parent = el.parentElement;
			if (!parent) { return; }
			var sibs = Array.prototype.slice.call(parent.children).filter(function (c) {
				return c.classList && c.classList.contains('pl-reveal');
			});
			var idx = sibs.indexOf(el);
			if (idx > 0) { el.style.transitionDelay = (Math.min(idx, 6) * 70) + 'ms'; }
		});

		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-visible');
					io.unobserve(entry.target);
				}
			});
		}, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });

		els.forEach(function (el) { io.observe(el); });
	}

	/* -------------------------------------------------------- Stat counters */
	function countUp(el) {
		var raw = el.dataset.plRaw || el.textContent;
		el.dataset.plRaw = raw;
		var match = raw.match(/(\d[\d,]*\.?\d*)/);
		if (!match) { return; }

		var numStr = match[1].replace(/,/g, '');
		var target = parseFloat(numStr);
		if (isNaN(target)) { return; }
		var decimals = (numStr.split('.')[1] || '').length;
		var hasComma = match[1].indexOf(',') > -1;
		var prefix = raw.slice(0, match.index);
		var suffix = raw.slice(match.index + match[1].length);
		var duration = 1400;
		var startTime = 0;

		function format(n) {
			var s = n.toFixed(decimals);
			if (hasComma) {
				s = Number(s).toLocaleString('en-US', { minimumFractionDigits: decimals, maximumFractionDigits: decimals });
			}
			return prefix + s + suffix;
		}
		function tick(now) {
			if (!startTime) { startTime = now; }
			var p = Math.min((now - startTime) / duration, 1);
			var eased = 1 - Math.pow(1 - p, 3);
			el.textContent = format(target * eased);
			if (p < 1) { window.requestAnimationFrame(tick); }
			else { el.textContent = raw; }
		}
		window.requestAnimationFrame(tick);
	}

	function initCounters() {
		var els = document.querySelectorAll('.pl-stat__value, .pl-metric__value');
		if (!els.length || reduceMotion || !('IntersectionObserver' in window)) { return; }
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) { countUp(entry.target); io.unobserve(entry.target); }
			});
		}, { threshold: 0.6 });
		els.forEach(function (el) { io.observe(el); });
	}

	/* -------------------------------------------------------------- FAQ */
	function initFaq() {
		var faq = document.getElementById('pl-faq');
		if (!faq) { return; }
		var items = Array.prototype.slice.call(faq.querySelectorAll('.pl-faq__item'));
		items.forEach(function (item) {
			item.addEventListener('toggle', function () {
				if (item.open) {
					items.forEach(function (other) { if (other !== item) { other.open = false; } });
				}
			});
		});
	}

	/* -------------------------------------------------------------- Chatbot */
	function initChat() {
		var root = document.getElementById('pl-chat');
		if (!root) { return; }
		var panel = document.getElementById('pl-chat-panel');
		var launcher = document.getElementById('pl-chat-launcher');
		var closeBtn = document.getElementById('pl-chat-close');
		var form = document.getElementById('pl-chat-form');
		var input = document.getElementById('pl-chat-input');
		var sendBtn = document.getElementById('pl-chat-send');
		var log = document.getElementById('pl-chat-log');
		var pending = false;

		function setOpen(open) {
			panel.classList.toggle('is-open', open);
			launcher.setAttribute('aria-expanded', open ? 'true' : 'false');
			if (open) { window.setTimeout(function () { input.focus(); }, 50); }
		}
		function scrollDown() { log.scrollTop = log.scrollHeight; }
		function addMsg(role, text) {
			var div = document.createElement('div');
			div.className = 'pl-chat__msg pl-chat__msg--' + (role === 'user' ? 'user' : 'bot');
			div.textContent = text;
			log.appendChild(div);
			scrollDown();
			return div;
		}

		launcher.addEventListener('click', function () { setOpen(!panel.classList.contains('is-open')); });
		closeBtn.addEventListener('click', function () { setOpen(false); });
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && panel.classList.contains('is-open')) { setOpen(false); }
		});

		function endpoint() {
			if (cfg.apiUrl) { return cfg.apiUrl.replace(/\/$/, '') + '/api/chat'; }
			return cfg.restUrl;
		}

		form.addEventListener('submit', function (e) {
			e.preventDefault();
			var text = (input.value || '').trim();
			if (!text || pending) { return; }
			input.value = '';
			addMsg('user', text);
			pending = true;
			sendBtn.disabled = true;
			var typing = addMsg('bot', '…');

			var headers = { 'Content-Type': 'application/json' };
			if (!cfg.apiUrl && cfg.nonce) { headers['X-WP-Nonce'] = cfg.nonce; }

			fetch(endpoint(), {
				method: 'POST',
				headers: headers,
				body: JSON.stringify({ message: text })
			})
				.then(function (res) { if (!res.ok) { throw new Error('bad response'); } return res.json(); })
				.then(function (data) {
					typing.textContent = (data && data.reply) ? data.reply :
						'Thanks! Please use the contact form below and we will get right back to you.';
				})
				.catch(function () {
					typing.textContent = 'I could not reach the server. Please use the contact section below, or book a call directly.';
				})
				.finally(function () {
					pending = false;
					sendBtn.disabled = false;
					scrollDown();
				});
		});
	}

	ready(function () {
		initTheme();
		initNav();
		initScroll();
		initReveals();
		initCounters();
		initFaq();
		initChat();
	});
})();
