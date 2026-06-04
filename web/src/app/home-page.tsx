"use client";

import { Header } from "@/components/Header";
import { Hero } from "@/components/Hero";
import { LogoStrip } from "@/components/LogoStrip";
import { Services } from "@/components/Services";
import { Metrics } from "@/components/Metrics";
import { CaseStudies } from "@/components/CaseStudies";
import { Portfolio } from "@/components/Portfolio";
import { Process } from "@/components/Process";
import { Testimonials } from "@/components/Testimonials";
import { CtaBand } from "@/components/CtaBand";
import { Blog } from "@/components/Blog";
import { BookCall } from "@/components/BookCall";
import { Contact } from "@/components/Contact";
import { Footer } from "@/components/Footer";
import { Chatbot } from "@/components/Chatbot";
import { SiteContentProvider } from "@/context/SiteContentProvider";

export default function HomePage() {
  return (
    <SiteContentProvider>
      <main className="min-h-screen overflow-x-hidden bg-page">
        <Header />
        <Hero />
        <LogoStrip />
        <Services />
        <Metrics />
        <CaseStudies />
        <Portfolio />
        <Process />
        <Testimonials />
        <CtaBand />
        <Blog />
        <BookCall />
        <Contact />
        <Footer />
        <Chatbot />
      </main>
    </SiteContentProvider>
  );
}
