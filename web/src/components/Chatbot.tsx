"use client";

import { useCallback, useEffect, useRef, useState } from "react";

type Msg = { role: "user" | "assistant"; text: string };

const apiBase = process.env.NEXT_PUBLIC_API_URL ?? "http://localhost:3001";

const welcome: Msg = {
  role: "assistant",
  text: "Hi — ask about Meta ads, SEO, pricing, our process, or how to reach the team.",
};

export function Chatbot() {
  const [open, setOpen] = useState(false);
  const [input, setInput] = useState("");
  const [msgs, setMsgs] = useState<Msg[]>([welcome]);
  const [pending, setPending] = useState(false);
  const listRef = useRef<HTMLDivElement>(null);

  const scrollBottom = useCallback(() => {
    const el = listRef.current;
    if (el) el.scrollTop = el.scrollHeight;
  }, []);

  useEffect(() => {
    scrollBottom();
  }, [msgs, open, pending, scrollBottom]);

  async function send() {
    const text = input.trim();
    if (!text || pending) return;
    setInput("");
    setMsgs((m) => [...m, { role: "user", text }]);
    setPending(true);
    try {
      const res = await fetch(`${apiBase}/api/chat`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ message: text }),
      });
      if (!res.ok) throw new Error();
      const data = (await res.json()) as { reply: string };
      setMsgs((m) => [...m, { role: "assistant", text: data.reply }]);
    } catch {
      setMsgs((m) => [
        ...m,
        {
          role: "assistant",
          text: "I could not reach the server. Please use the Contact section below, or ensure the API is running on port 3001.",
        },
      ]);
    } finally {
      setPending(false);
    }
  }

  return (
    <div className="fixed bottom-4 right-4 z-[60] flex flex-col items-end gap-2 sm:bottom-6 sm:right-6">
      {open && (
        <div
          id="chat-panel"
          role="dialog"
          aria-label="Chat assistant"
          className="flex h-[min(28rem,calc(100vh-8rem))] w-[min(22rem,calc(100vw-2rem))] flex-col overflow-hidden rounded-2xl border border-zinc-200/90 bg-paper shadow-2xl"
        >
          <div className="flex items-center justify-between border-b border-zinc-200/90 bg-page px-4 py-3">
            <div>
              <p className="text-sm font-semibold text-ink">PulseLift assistant</p>
              <p className="text-[11px] text-zinc-500">Answers common questions</p>
            </div>
            <button
              type="button"
              onClick={() => setOpen(false)}
              className="rounded-lg p-2 text-zinc-500 transition hover:bg-zinc-100 hover:text-ink"
              aria-label="Close chat"
            >
              <span aria-hidden className="text-lg leading-none">
                ×
              </span>
            </button>
          </div>
          <div
            ref={listRef}
            className="flex-1 space-y-3 overflow-y-auto px-4 py-3"
            aria-live="polite"
          >
            {msgs.map((x, i) => (
              <div
                key={`${i}-${x.role}`}
                className={`max-w-[92%] rounded-2xl px-3 py-2 text-sm leading-relaxed ${
                  x.role === "user"
                    ? "ml-auto bg-ink text-white"
                    : "mr-auto border border-zinc-200/90 bg-zinc-50 text-zinc-800"
                }`}
              >
                {x.text}
              </div>
            ))}
            {pending && (
              <div className="mr-auto rounded-2xl border border-zinc-200/90 bg-zinc-50 px-3 py-2 text-sm text-zinc-500">
                …
              </div>
            )}
          </div>
          <form
            className="border-t border-zinc-200/90 p-3"
            onSubmit={(e) => {
              e.preventDefault();
              void send();
            }}
          >
            <div className="flex gap-2">
              <label htmlFor="chat-input" className="sr-only">
                Message
              </label>
              <input
                id="chat-input"
                value={input}
                onChange={(e) => setInput(e.target.value)}
                placeholder="Type a question…"
                maxLength={2000}
                className="min-w-0 flex-1 rounded-xl border border-zinc-200 bg-paper px-3 py-2 text-sm text-ink outline-none focus:border-lift/50 focus:ring-2 focus:ring-lift/20"
                disabled={pending}
              />
              <button
                type="submit"
                disabled={pending || !input.trim()}
                className="shrink-0 rounded-xl bg-ink px-4 py-2 text-sm font-semibold text-white transition hover:bg-zinc-800 disabled:opacity-40"
              >
                Send
              </button>
            </div>
          </form>
        </div>
      )}
      <button
        type="button"
        onClick={() => setOpen((v) => !v)}
        className="flex h-14 w-14 items-center justify-center rounded-full bg-ink text-white shadow-lg ring-2 ring-lift/40 transition hover:bg-zinc-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-lift"
        aria-expanded={open}
        aria-controls="chat-panel"
        id="chat-launcher"
      >
        <span className="sr-only">{open ? "Close chat" : "Open chat"}</span>
        {open ? (
          <span className="text-2xl leading-none" aria-hidden>
            ×
          </span>
        ) : (
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden className="text-white">
            <path
              d="M12 3C7.03 3 3 6.58 3 11c0 1.78.64 3.45 1.76 4.9L3 21l5.38-1.62C9.62 20.45 10.78 20.75 12 20.75c4.97 0 9-3.58 9-8s-4.03-8-9-8Z"
              stroke="currentColor"
              strokeWidth="1.5"
              strokeLinejoin="round"
            />
            <circle cx="9" cy="11" r="1" fill="currentColor" />
            <circle cx="12" cy="11" r="1" fill="currentColor" />
            <circle cx="15" cy="11" r="1" fill="currentColor" />
          </svg>
        )}
      </button>
    </div>
  );
}
