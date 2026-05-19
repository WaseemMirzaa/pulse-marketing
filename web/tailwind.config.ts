import type { Config } from "tailwindcss";

export default {
  content: [
    "./src/pages/**/*.{js,ts,jsx,tsx,mdx}",
    "./src/components/**/*.{js,ts,jsx,tsx,mdx}",
    "./src/app/**/*.{js,ts,jsx,tsx,mdx}",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ["var(--font-sans)", "system-ui", "sans-serif"],
        display: ["var(--font-display)", "Georgia", "serif"],
      },
      colors: {
        page: "#f5f4f0",
        paper: "#ffffff",
        ink: "#0f0f10",
        lift: "#65a30d",
        "lift-bright": "#84cc16",
        "lift-soft": "#ecfccb",
      },
      backgroundImage: {
        mesh:
          "radial-gradient(ellipse 85% 55% at 12% -8%, rgba(132,204,22,0.18), transparent), radial-gradient(ellipse 70% 45% at 92% 0%, rgba(99,102,241,0.12), transparent), radial-gradient(ellipse 55% 35% at 50% 100%, rgba(15,15,16,0.04), transparent)",
        "grid-fade":
          "linear-gradient(to bottom, rgba(245,244,240,0) 0%, #f5f4f0 88%), linear-gradient(rgba(15,15,16,0.06) 1px, transparent 1px), linear-gradient(90deg, rgba(15,15,16,0.06) 1px, transparent 1px)",
      },
      backgroundSize: {
        grid: "64px 64px",
      },
      boxShadow: {
        card: "0 1px 0 rgba(15,15,16,0.06), 0 12px 40px -24px rgba(15,15,16,0.12)",
        lift: "0 8px 32px -8px rgba(101,163,13,0.35)",
      },
      animation: {
        "fade-up": "fadeUp 0.7s cubic-bezier(0.16,1,0.3,1) forwards",
        marquee: "marquee 32s linear infinite",
        float: "float 8s ease-in-out infinite",
      },
      keyframes: {
        fadeUp: {
          "0%": { opacity: "0", transform: "translateY(20px)" },
          "100%": { opacity: "1", transform: "translateY(0)" },
        },
        marquee: {
          "0%": { transform: "translateX(0)" },
          "100%": { transform: "translateX(-50%)" },
        },
        float: {
          "0%,100%": { transform: "translateY(0)" },
          "50%": { transform: "translateY(-8px)" },
        },
      },
    },
  },
  plugins: [],
} satisfies Config;
