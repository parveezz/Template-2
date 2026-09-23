const Press = () => {
  return (
    <section className="w-full min-h-[70vh] bg-surface-muted px-5 py-16 text-text-main md:px-8 lg:px-10 lg:py-24">
      <div className="mx-auto w-full max-w-[1250px]">
        <div className="border-b border-border pb-12">
          <p className="mb-4 font-sans text-[10px] font-semibold uppercase tracking-[3px] text-text-muted">
            Press
          </p>
          <h1 className="font-sans text-[42px] font-medium leading-tight tracking-[-1px] sm:text-[52px] md:text-[64px]">
            Press & Media
          </h1>
          <p className="mt-6 w-full max-w-[500px] font-sans text-[14px] leading-6 text-text-muted">
            Latest news, press releases, and media resources.
          </p>
        </div>
        
<div className="py-16">
          <div className="flex flex-col gap-8">
            {[
              { date: 'September 12, 2026', title: 'ZIH Consultancy Expands Global Presence with New Dubai Office', outlet: 'Global Business Wire' },
              { date: 'August 04, 2026', title: 'How ZIH is Redefining Performance Marketing in the AI Era', outlet: 'Marketing Weekly' },
              { date: 'June 22, 2026', title: 'Awarded Top B2B Agency of the Year', outlet: 'Agency Awards' }
            ].map((news, idx) => (
              <div key={idx} className="border-b border-border pb-8 last:border-none">
                <span className="font-sans text-[12px] text-text-muted">{news.date} • {news.outlet}</span>
                <h3 className="mt-2 font-sans text-[24px] font-medium leading-snug text-text-main md:text-[28px]">
                  {news.title}
                </h3>
                <button className="mt-4 border-b border-brand pb-1 font-sans text-[12px] font-semibold uppercase tracking-[1px] text-text-main transition-all hover:text-text-muted hover:border-[#666]">
                  Read Full Release
                </button>
              </div>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
};

export default Press;
