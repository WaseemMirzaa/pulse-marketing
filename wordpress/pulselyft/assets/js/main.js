/**
 * PulseLyft theme front-end behavior.
 * - Mobile nav toggle
 * - Scroll-reveal animations (IntersectionObserver)
 * - Floating chat assistant (REST endpoint or external API)
 *
 * @package PulseLyft
 */
(function () {
	'use strict';

	var cfg = window.PulseLyftCfg || {};

	/* ----------------------------------------------------------- Mobile nav */
	function initNav() {
		var burger = document.getElementById('pl-burger');
		var menu = document.getElementById('pl-mobile-nav');
		if (!burger || !menu) {
			return;
		}
		burger.addEventListener('click', function () {
			var open = menu.classList.toggle('is-open');
			burger.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
		// Close on link tap.
		menu.querySelectorAll('a').forEach(function (a) {
			a.addEventListener('click', function () {
				menu.classList.remove('is-open');
				burger.setAttribute('aria-expanded', 'false');
			});
		});
	}

	/* ------------------------------------------------------- Scroll reveals */
	function initReveals() {
		var els = document.querySelectorAll('.pl-reveal');
		if (!els.length) {
			return;
		}
		var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
		if (reduce || !('IntersectionObserver' in window)) {
			els.forEach(function (el) { el.classList.add('is-visible'); });
			return;
		}
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

	/* -------------------------------------------------------------- Chatbot */
	function initChat() {
		var root = document.getElementById('pl-chat');
		if (!root) {
			return;
		}
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
			if (open) {
				window.setTimeout(function () { input.focus(); }, 50);
			}
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

		launcher.addEventListener('click', function () {
			setOpen(!panel.classList.contains('is-open'));
		});
		closeBtn.addEventListener('click', function () { setOpen(false); });
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && panel.classList.contains('is-open')) { setOpen(false); }
		});

		function endpoint() {
			// Prefer an external Nest-style API if configured, else theme REST.
			if (cfg.apiUrl) {
				return cfg.apiUrl.replace(/\/$/, '') + '/api/chat';
			}
			return cfg.restUrl;
		}

		form.addEventListener('submit', function (e) {
			e.preventDefault();
			var text = (input.value || '').trim();
			if (!text || pending) {
				return;
			}
			input.value = '';
			addMsg('user', text);
			pending = true;
			sendBtn.disabled = true;
			var typing = addMsg('bot', '…');

			var headers = { 'Content-Type': 'application/json' };
			if (!cfg.apiUrl && cfg.nonce) {
				headers['X-WP-Nonce'] = cfg.nonce;
			}

			fetch(endpoint(), {
				method: 'POST',
				headers: headers,
				body: JSON.stringify({ message: text })
			})
				.then(function (res) {
					if (!res.ok) { throw new Error('bad response'); }
					return res.json();
				})
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

	function ready(fn) {
		if (document.readyState !== 'loading') {
			fn();
		} else {
			document.addEventListener('DOMContentLoaded', fn);
		}
	}

	ready(function () {
		initNav();
		initReveals();
		initChat();
	});
})();
