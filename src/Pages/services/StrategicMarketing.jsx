import SEO from "../../Components/SEO";


const StrategicMarketing = () => {
    const services = [
        "Market Research",
        "Marketing Strategy",
        "Audience Analysis",
        "Competitor Analysis",
        "Growth Planning",
    ];

    return (
        <section className="w-full min-h-screen bg-surface-muted px-5 py-12 text-text-main md:px-8 lg:px-10">
      <SEO title="Strategic Marketing" description="Clear marketing strategies built around your business." />

            <div className="mx-auto w-full max-w-[1250px]">

                {/* Hero */}
                <div className="border-b border-border pb-8 md:pb-12">
                    <p className="mb-5 font-sans text-[10px] font-semibold uppercase tracking-[3px] text-text-muted">
                        Our Services
                    </p>

                    <h1 className="max-w-[900px] font-sans text-[46px] font-medium leading-[1.05] tracking-tight sm:text-[54px] md:text-[70px] lg:text-[82px]">
                        Strategic
                        <br />
                        Marketing
                    </h1>

                    <p className="mt-8 max-w-[700px] font-sans text-[14px] leading-7 text-text-muted md:text-[16px] md:leading-8">
                        We build clear marketing strategies that connect your business
                        goals with the right audience, positioning, channels, and
                        opportunities for sustainable growth.
                    </p>
                </div>
                
                {/* Hero Image */}
                <div className="mt-12 aspect-[21/9] w-full overflow-hidden bg-surface-muted">
                   <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=2015&auto=format&fit=crop" alt="StrategicMarketing" className="h-full w-full object-cover" />
                </div>

                {/* Overview */}
                <div className="mx-auto grid w-full max-w-[1250px] grid-cols-1 gap-12 py-8 md:py-12 lg:grid-cols-2 lg:gap-24">

                    <div>
                        <p className="mb-4 font-sans text-[10px] font-semibold uppercase tracking-[3px] text-text-muted">
                            What We Do
                        </p>

                        <h2 className="font-sans text-[32px] font-medium leading-tight md:text-[44px]">
                            Strategy before execution.
                        </h2>
                    </div>

                    <div>
                        <p className="font-sans text-[15px] leading-8 text-text-muted">
                            Every effective marketing campaign starts with a strong
                            understanding of the business, market, audience, and
                            competition. We develop practical strategies designed around
                            your objectives and help turn them into focused marketing
                            actions.
                        </p>
                    </div>
                </div>

                {/* Services */}
                <div className="border-t border-border">
                    <div className="mx-auto grid w-full max-w-[1250px] grid-cols-1 lg:grid-cols-2">

                        <div className="border-b border-border py-10 lg:border-b-0 lg:border-r lg:pr-16">
                            <p className="font-sans text-[10px] font-semibold uppercase tracking-[3px] text-text-muted">
                                Our Approach
                            </p>
                        </div>

                        <div>
                            {services.map((service, index) => (
                                <div
                                    key={service}
                                    className="border-b border-border py-6"
                                >
                                    <div className="flex items-center justify-between gap-5">
                                        <span className="font-sans text-[16px] md:text-[18px]">
                                            {service}
                                        </span>

                                        <span className="font-sans text-[12px] text-text-muted">
                                            0{index + 1}
                                        </span>
                                    </div>
                                </div>
                            ))}
                        </div>

                    </div>
                </div>

                {/* CTA */}
                <div className="mx-auto flex w-full max-w-[1250px] flex-col gap-8 py-10 md:flex-row md:items-end md:justify-between md:py-16">
                    <h2 className="max-w-[650px] font-sans text-[26px] font-medium leading-tight md:text-[40px]">
                        Build a strategy that moves your business forward.
                    </h2>

                    <a
                        href="/contact"
                        className="w-fit border border-brand bg-brand px-7 py-3 font-sans text-xs font-semibold uppercase tracking-[1px] text-surface transition-all duration-300 hover:bg-transparent hover:text-text-main"
                    >
                        Let's Talk
                    </a>
                </div>

            </div>
        </section>
    );
};

export default StrategicMarketing;