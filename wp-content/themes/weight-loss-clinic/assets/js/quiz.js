/**
 * Weight Loss Clinic — Intake / Eligibility Journey
 *
 * Premium split-screen guided flow. One screen at a time:
 *   welcome → questions (phase 1) → questions (phase 2) → pathway preview
 *   → result
 *
 * Kept deliberately short (8 steps, no interstitial screens): compliance
 * framing lives on the welcome screen, the consent text, and the result.
 *
 * Config is passed via data attributes on #fc-quiz:
 *   data-checkout-url, data-review-url, data-contact-url, data-price-from
 *   data-img-welcome, data-img-questions, data-img-clinical,
 *   data-img-medical, data-img-review, data-img-pathway
 *
 * Result states:
 *  - eligible:    likely eligible, route to intake/checkout
 *  - review:      clinician review required (same URL, different framing)
 *  - unsuitable:  program may not be appropriate (route to contact)
 */

( function () {
    'use strict';

    var root = document.getElementById( 'fc-quiz' );
    if ( ! root ) return;

    var viewport    = document.getElementById( 'fc-quiz-viewport' );
    var progressBar = document.getElementById( 'fc-quiz-progress' );
    var progressPct = document.getElementById( 'fc-intake-pct' );
    var backBtn     = document.getElementById( 'fc-quiz-back' );
    var stepCounter = document.getElementById( 'fc-quiz-counter' );
    var imageLayerA = document.getElementById( 'fc-intake-image-a' );
    var imageLayerB = document.getElementById( 'fc-intake-image-b' );
    var imageQuote  = document.getElementById( 'fc-intake-imagequote' );

    // Config — from data attributes (set by PHP from brand-config.php)
    var cfg = {
        checkoutUrl: root.getAttribute( 'data-checkout-url' ) || '/patient-intake/',
        bookingUrl:  root.getAttribute( 'data-booking-url' )  || '/book/',
        reviewUrl:   root.getAttribute( 'data-review-url' )   || '/contact/',
        contactUrl:  root.getAttribute( 'data-contact-url' )  || '/contact/',
        priceFrom:   root.getAttribute( 'data-price-from' )   || '149',
        images: {
            welcome:   root.getAttribute( 'data-img-welcome' ),
            questions: root.getAttribute( 'data-img-questions' ),
            clinical:  root.getAttribute( 'data-img-clinical' ),
            medical:   root.getAttribute( 'data-img-medical' ),
            review:    root.getAttribute( 'data-img-review' ),
            pathway:   root.getAttribute( 'data-img-pathway' ),
        },
    };

    /* ── Question Definitions ────────────────────────────────────
     * Each screen is a "node" with one of several shapes:
     *   - { kind:'welcome' }            — intro / begin state
     *   - { kind:'pathway', ... }       — recommended-pathway bridge
     *   - { kind:'question', ... }      — a real quiz step
     *   - { kind:'result' }             — final state (computed)
     * The progress bar only counts questions (so it reflects real completion).
     *
     * QUESTION SOURCE: when the WLC plugin localises a schema derived from
     * the mapped Gravity Form (window.wlcQuiz.schema), the questions below
     * are REPLACED by it — editing the form in the GF admin edits this quiz.
     * The hardcoded set is only the fallback for when GF is unavailable.
     */

    var questions = [
        {
            id: 'age', phase: 1,
            question: 'How old are you?',
            helper: 'This takes less than 2 minutes. Your answers are confidential.',
            type: 'select',
            options: [
                { label: '18\u201329', value: '18-29' },
                { label: '30\u201339', value: '30-39' },
                { label: '40\u201349', value: '40-49' },
                { label: '50\u201359', value: '50-59' },
                { label: '60+',        value: '60+' },
            ],
        },
        {
            id: 'sex', phase: 1,
            question: 'What is your biological sex?',
            helper: 'This helps our clinicians recommend the right treatment.',
            type: 'select',
            options: [
                { label: 'Male',   value: 'male' },
                { label: 'Female', value: 'female' },
            ],
        },
        {
            id: 'body', phase: 1,
            question: 'What is your height and weight?',
            helper: 'Used to estimate your BMI for the clinical review.',
            type: 'body',
            fields: [
                { key: 'height', label: 'Height', placeholder: 'Height in cm', suffix: 'cm', min: 120, max: 220 },
                { key: 'weight', label: 'Weight', placeholder: 'Weight in kg', suffix: 'kg', min: 40,  max: 300 },
            ],
        },
        {
            id: 'goal', phase: 1,
            question: 'How much weight would you like to lose?',
            type: 'select',
            options: [
                { label: '5\u201310 kg',  value: '5-10' },
                { label: '10\u201320 kg', value: '10-20' },
                { label: '20\u201330 kg', value: '20-30' },
                { label: '30\u201345 kg', value: '30-45' },
                { label: '45+ kg',        value: '45+' },
            ],
        },
        {
            id: 'prior', phase: 1,
            question: 'Have you tried to lose weight before?',
            helper: 'There are no wrong answers. This helps personalise your plan.',
            type: 'select',
            options: [
                { label: 'Yes, with diet and exercise only',          value: 'diet-exercise' },
                { label: 'Yes, with medication or a medical program', value: 'medical' },
                { label: 'Yes, multiple approaches',                  value: 'multiple' },
                { label: 'No, this would be my first attempt',        value: 'none' },
            ],
        },
        {
            id: 'medical', phase: 2,
            question: 'Do any of the following apply to you?',
            helper: 'Select all that apply. This ensures your safety.',
            type: 'multiselect',
            options: [
                { label: 'Type 1 diabetes',                                    value: 'type1-diabetes', flag: 'unsuitable' },
                { label: 'History of pancreatitis',                             value: 'pancreatitis',   flag: 'unsuitable' },
                { label: 'History of medullary thyroid carcinoma or MEN 2',     value: 'mtc-men2',       flag: 'unsuitable' },
                { label: 'Currently pregnant or planning pregnancy',            value: 'pregnant',       flag: 'unsuitable' },
                { label: 'Type 2 diabetes',                                     value: 'type2-diabetes', flag: 'review' },
                { label: 'Heart disease or high blood pressure',                value: 'heart-bp',       flag: 'review' },
                { label: 'Taking other prescription medications',               value: 'other-meds',     flag: 'review' },
                { label: 'None of the above',                                   value: 'none',           flag: 'clear', exclusive: true },
            ],
        },
        {
            id: 'commitment', phase: 2,
            question: 'How ready are you to start?',
            helper: 'Almost there — a couple of details so we can reach you.',
            type: 'select',
            options: [
                { label: 'Ready to start as soon as possible', value: 'ready' },
                { label: 'Interested, want to learn more',     value: 'interested' },
                { label: 'Just exploring options',              value: 'exploring' },
            ],
        },
        {
            id: 'contact', phase: 2,
            question: 'Where should we send your next steps?',
            helper: 'Used only so the clinical team can contact you about your assessment.',
            type: 'contact',
            consentLabel: 'I consent to an Australian-registered clinician reviewing my assessment, and I understand that not all patients are approved.',
        },
    ];

    /* ── Gravity-Forms-driven questions ─────────────────────────────
       The plugin localises a schema built from the mapped GF form. When
       present it replaces the fallback set above, so the quiz content is
       managed in the Gravity Forms editor. */
    var gfSchema = window.wlcQuiz && window.wlcQuiz.schema;
    if ( gfSchema && gfSchema.steps && gfSchema.steps.length ) {
        questions = gfSchema.steps;
    }

    var totalQuestions = questions.length;

    /* ── Pathway / welcome content ───────────────────────────────── */

    var welcome = {
        kind: 'welcome',
        imageKey: 'welcome',
        eyebrow: 'Clinically reviewed intake',
        headline: 'Begin your confidential assessment',
        body: 'A short confidential assessment to help determine whether clinician-led weight management may be suitable for you. Reviewed by an Australian-registered clinician. Not all patients are approved.',
        meta: [
            { icon: 'clock',  label: 'Takes about 2 minutes' },
            { icon: 'lock',   label: 'Private &amp; encrypted' },
            { icon: 'shield', label: 'Clinician-reviewed' },
        ],
        disclaimer: 'Not every patient is approved for telehealth treatment. Final suitability is determined by a qualified clinician after review.',
        cta: 'Begin assessment',
        imageQuote: {
            text: 'A calm, guided pathway — reviewed by Australian-registered clinicians.',
            attribution: 'Telehealth weight management · Clinically supervised',
        },
    };

    var pathwayStep = {
        kind: 'pathway',
        imageKey: 'pathway',
    };

    /* ── Build the screen sequence ──────────────────────────────── */

    function buildSequence() {
        // Deliberately linear: welcome → every question → pathway. No
        // interstitial screens — they read as dead-ends mid-flow.
        var built = [ welcome ];
        questions.forEach( function ( q ) {
            built.push( q );
        } );
        built.push( pathwayStep );
        return built;
    }

    var sequence = buildSequence();

    var cursor  = 0;       // index into sequence
    var answers = {};

    /* Answer storage: core steps write to answers[id]; admin-added GF
       questions (extraId) write to answers.extra[fieldId]. */
    function setAnswer( step, value ) {
        if ( step.extraId ) {
            answers.extra = answers.extra || {};
            answers.extra[ step.extraId ] = value;
        } else {
            answers[ step.id ] = value;
        }
    }
    function getAnswer( step ) {
        if ( step.extraId ) return ( answers.extra || {} )[ step.extraId ];
        return answers[ step.id ];
    }
    var answeredCount = 0; // how many questions completed
    var quizStarted = false;

    /* ── Starter handoff (from homepage cta-starter) ────────────────
       The homepage CTA captures the user's first intent before they
       arrive here. We accept it from sessionStorage (preferred) or
       the URL querystring as a fallback. The value is stored on
       `answers` so it travels with the assessment, and we skip the
       welcome screen so the user lands straight on a real question. */
    var STARTER_KEYS = [ 'starter_intent' ];
    function readStarter() {
        var picked = {};
        var params;
        try { params = new URLSearchParams( window.location.search ); }
        catch ( e ) { params = null; }

        STARTER_KEYS.forEach( function ( key ) {
            var value = '';
            try {
                var stored = sessionStorage.getItem( 'fc_' + key );
                if ( stored ) value = stored;
            } catch ( e ) { /* storage blocked */ }
            if ( ! value && params ) {
                var qs = params.get( key );
                if ( qs ) value = qs;
            }
            if ( value ) picked[ key ] = String( value ).slice( 0, 64 );
        } );
        return picked;
    }

    var starter = readStarter();
    if ( starter.starter_intent ) {
        answers.starter_intent = starter.starter_intent;
        // Skip the welcome screen — the user has already chosen to begin.
        if ( sequence[0] && sequence[0].kind === 'welcome' ) {
            cursor = 1;
            quizStarted = true;
        }
        if ( window.fcTrack ) {
            fcTrack( 'assessment_started_with_intent', { intent: answers.starter_intent } );
        }
        // Clear sessionStorage so a refresh doesn't re-skip the welcome.
        try { sessionStorage.removeItem( 'fc_starter_intent' ); } catch ( e ) {}
    }

    /* ── Image panel swapping ──────────────────────────────────── */

    var currentImageKey = 'welcome';
    var frontIsA = true;

    function setImage( key, quote ) {
        if ( ! key || key === currentImageKey ) return;
        var url = cfg.images[ key ];
        if ( ! url ) return;

        var front = frontIsA ? imageLayerA : imageLayerB;
        var back  = frontIsA ? imageLayerB : imageLayerA;

        back.style.backgroundImage = 'url(\'' + url + '\')';
        // Force reflow to ensure transition runs.
        // eslint-disable-next-line no-unused-expressions
        back.offsetWidth;
        back.classList.add( 'fc-intake__image-layer--active' );
        front.classList.remove( 'fc-intake__image-layer--active' );

        frontIsA = ! frontIsA;
        currentImageKey = key;

        if ( quote && imageQuote ) {
            // Soft cross-fade the quote text.
            imageQuote.classList.add( 'fc-intake__imagequote--fading' );
            setTimeout( function () {
                imageQuote.innerHTML =
                    '<p class="fc-intake__imagequote-text">' + escHtml( quote.text ) + '</p>' +
                    '<p class="fc-intake__imagequote-attribution">' + escHtml( quote.attribution ) + '</p>';
                imageQuote.classList.remove( 'fc-intake__imagequote--fading' );
            }, 260 );
        }
    }

    /* ── Progress display ──────────────────────────────────────── */

    function updateProgress() {
        var pct = Math.round( ( answeredCount / totalQuestions ) * 100 );
        progressBar.style.width = pct + '%';
        progressBar.parentElement.setAttribute( 'aria-valuenow', pct );
        if ( progressPct ) progressPct.textContent = pct + '%';

        var node = sequence[ cursor ];
        if ( ! node ) return;

        if ( node.kind === 'welcome' ) {
            stepCounter.textContent = 'Welcome';
        } else if ( node.kind === 'pathway' ) {
            stepCounter.textContent = 'Your pathway';
        } else if ( node.kind === 'result' ) {
            stepCounter.textContent = 'Next steps';
        } else if ( node.kind === 'question' || node.type ) {
            // question
            stepCounter.textContent = 'Question ' + ( answeredCount + 1 ) + ' of ' + totalQuestions;
        }
    }

    function updateBackButton() {
        backBtn.style.visibility = cursor > 0 ? 'visible' : 'hidden';
    }

    /* ── Rendering per node kind ───────────────────────────────── */

    var hasRendered = false;

    function renderCurrent() {
        var node = sequence[ cursor ];
        if ( ! node ) return;

        if ( node.kind === 'welcome' ) {
            renderWelcome( node );
            setImage( node.imageKey, node.imageQuote );
        } else if ( node.kind === 'pathway' ) {
            renderPathway();
            setImage( 'pathway', {
                text: 'Your next step — a clinician-reviewed intake.',
                attribution: 'Weight Loss Clinic · Australian registered clinicians',
            } );
        } else if ( node.kind === 'result' ) {
            renderResult();
        } else {
            // question
            var q = node;
            renderQuestion( q );
            // Swap images on phase change.
            var phaseImg = q.phase === 2 ? 'medical' : 'questions';
            setImage( phaseImg, {
                text: q.phase === 2
                    ? 'Medical history helps us keep you safe.'
                    : 'A few quick questions so we can tailor your pathway.',
                attribution: 'Clinically reviewed · Weight Loss Clinic',
            } );
        }

        updateProgress();
        updateBackButton();

        if ( hasRendered ) {
            // Subsequent step changes: align the assessment section
            // with the top of the viewport (below any sticky header).
            scrollAssessmentToTop();
        } else {
            // First render after arriving on /quiz/: keep the page at
            // absolute top so the user sees the assessment from the
            // very beginning rather than mid-page. Use instant scroll
            // (not smooth) to avoid a visible downward jump from any
            // browser-restored scroll position.
            hasRendered = true;
            window.scrollTo( 0, 0 );
        }
    }

    function scrollAssessmentToTop() {
        // Prefer aligning the assessment section's top edge with the
        // very top of the viewport — this is what users intuitively
        // expect when changing steps.
        var target = root.getBoundingClientRect().top + window.pageYOffset;
        // Account for any sticky site header.
        var headerEl = document.getElementById( 'fc-header' );
        var headerH  = headerEl ? headerEl.offsetHeight : 0;
        target = Math.max( 0, target - headerH );
        window.scrollTo( { top: target, behavior: 'smooth' } );
    }

    /* ── Welcome ───────────────────────────────────────────────── */

    function renderWelcome( node ) {
        var icons = {
            clock:  '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
            lock:   '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>',
            shield: '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
        };

        var html = '<div class="fc-intake__screen fc-intake__screen--welcome">';
        html += '<span class="fc-intake__eyebrow">' + escHtml( node.eyebrow ) + '</span>';
        html += '<h1 class="fc-intake__headline">' + escHtml( node.headline ) + '</h1>';
        html += '<p class="fc-intake__body">' + escHtml( node.body ) + '</p>';

        html += '<ul class="fc-intake__meta">';
        node.meta.forEach( function ( m ) {
            html += '<li class="fc-intake__meta-item">' +
                '<span class="fc-intake__meta-icon">' + ( icons[ m.icon ] || '' ) + '</span>' +
                '<span>' + m.label + '</span>' +
            '</li>';
        } );
        html += '</ul>';

        html += '<button class="fc-btn fc-btn--primary fc-intake__cta" type="button" id="fc-intake-begin">' + escHtml( node.cta ) + '</button>';
        html += '<p class="fc-intake__disclaimer">' + escHtml( node.disclaimer ) + '</p>';
        html += '</div>';

        viewport.innerHTML = html;

        var btn = document.getElementById( 'fc-intake-begin' );
        if ( btn ) btn.addEventListener( 'click', advance );
    }

    /* ── Question ──────────────────────────────────────────────── */

    function renderQuestion( step ) {
        var html = '<div class="fc-intake__screen fc-intake__screen--question" data-step="' + step.id + '">';
        html += '<span class="fc-intake__eyebrow">Question ' + ( answeredCount + 1 ) + ' of ' + totalQuestions + '</span>';
        html += '<h2 class="fc-intake__headline fc-intake__headline--h2">' + escHtml( step.question ) + '</h2>';
        if ( step.helper ) {
            html += '<p class="fc-intake__body fc-intake__body--muted">' + escHtml( step.helper ) + '</p>';
        }

        if ( step.type === 'select' ) {
            html += renderSelect( step );
        } else if ( step.type === 'multiselect' ) {
            html += renderMultiSelect( step );
        } else if ( step.type === 'body' ) {
            html += renderBody( step );
        } else if ( step.type === 'input' ) {
            html += renderInput( step );
        } else if ( step.type === 'contact' ) {
            html += renderContact( step );
        }

        html += '</div>';
        viewport.innerHTML = html;
        attachStepListeners( step );
    }

    function renderSelect( step ) {
        var html = '<div class="fc-quiz__options">';
        step.options.forEach( function ( opt ) {
            var selected = getAnswer( step ) === opt.value ? ' is-selected' : '';
            html += '<button class="fc-quiz__option' + selected + '" type="button" data-value="' + escAttr( opt.value ) + '">';
            html += escHtml( opt.label );
            html += '<span class="fc-quiz__option-arrow" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg></span>';
            html += '</button>';
        } );
        html += '</div>';
        return html;
    }

    function renderMultiSelect( step ) {
        var current = getAnswer( step ) || [];
        var html = '<div class="fc-quiz__options fc-quiz__options--multi">';
        step.options.forEach( function ( opt ) {
            var selected = current.indexOf( opt.value ) !== -1 ? ' is-selected' : '';
            html += '<button class="fc-quiz__option' + selected + '" type="button" data-value="' + escAttr( opt.value ) + '" data-exclusive="' + ( opt.exclusive ? 'true' : 'false' ) + '">';
            html += '<span class="fc-quiz__option-check" aria-hidden="true"></span>';
            html += '<span class="fc-quiz__option-label">' + escHtml( opt.label ) + '</span>';
            html += '</button>';
        } );
        html += '</div>';
        html += '<div class="fc-quiz__actions"><button class="fc-btn fc-btn--primary fc-quiz__continue" type="button" ' + ( current.length === 0 ? 'disabled' : '' ) + '>Continue</button></div>';
        return html;
    }

    /* ── Height + weight on one screen ─────────────────────────── */

    function renderBody( step ) {
        var html = '';
        step.fields.forEach( function ( f ) {
            var val = answers[ f.key ] || '';
            html += '<div class="fc-quiz__input-wrap">';
            html += '<input class="fc-quiz__input" type="number" inputmode="numeric" data-key="' + escAttr( f.key ) + '"';
            html += ' placeholder="' + escAttr( f.placeholder || '' ) + '"';
            html += ' aria-label="' + escAttr( f.label || f.key ) + '"';
            if ( f.min !== undefined ) html += ' min="' + f.min + '"';
            if ( f.max !== undefined ) html += ' max="' + f.max + '"';
            if ( val ) html += ' value="' + escAttr( val ) + '"';
            html += '>';
            if ( f.suffix ) html += '<span class="fc-quiz__suffix">' + escHtml( f.suffix ) + '</span>';
            html += '</div>';
        } );
        var valid = isValidBody( step );
        html += '<div class="fc-quiz__actions"><button class="fc-btn fc-btn--primary fc-quiz__continue" type="button" ' + ( ! valid ? 'disabled' : '' ) + '>Continue</button></div>';
        return html;
    }

    function isValidBody( step ) {
        return step.fields.every( function ( f ) {
            var n = Number( answers[ f.key ] );
            if ( ! answers[ f.key ] || isNaN( n ) ) return false;
            if ( f.min !== undefined && n < f.min ) return false;
            if ( f.max !== undefined && n > f.max ) return false;
            return true;
        } );
    }

    /* ── Generic single-input step (admin-added GF text/number/textarea) ── */

    function renderInput( step ) {
        var val  = getAnswer( step ) || '';
        var html = '<div class="fc-quiz__input-wrap">';
        if ( step.inputType === 'textarea' ) {
            html += '<textarea class="fc-quiz__input fc-quiz__input--area" rows="4">' + escHtml( val ) + '</textarea>';
        } else {
            html += '<input class="fc-quiz__input" type="' + ( step.inputType === 'number' ? 'number' : 'text' ) + '"';
            if ( step.inputType === 'number' ) html += ' inputmode="numeric"';
            if ( val ) html += ' value="' + escAttr( val ) + '"';
            html += '>';
        }
        html += '</div>';
        var ready = step.optional || String( val ).trim() !== '';
        html += '<div class="fc-quiz__actions"><button class="fc-btn fc-btn--primary fc-quiz__continue" type="button" ' + ( ready ? '' : 'disabled' ) + '>Continue</button></div>';
        return html;
    }

    /* ── Contact details (name + email + optional phone) ────────── */

    function renderContact( step ) {
        var val = answers[ step.id ] || { name: '', email: '', phone: '' };
        var html = '<div class="fc-quiz__contact">';
        html += '<label class="fc-quiz__field">';
        html += '<span class="fc-quiz__field-label">First name</span>';
        html += '<input class="fc-quiz__input fc-quiz__input--text" type="text" name="name" autocomplete="given-name" placeholder="Your first name" value="' + escAttr( val.name || '' ) + '" required>';
        html += '</label>';
        html += '<label class="fc-quiz__field">';
        html += '<span class="fc-quiz__field-label">Email address</span>';
        html += '<input class="fc-quiz__input fc-quiz__input--text" type="email" name="email" autocomplete="email" placeholder="you@example.com" value="' + escAttr( val.email || '' ) + '" required>';
        html += '</label>';
        html += '<label class="fc-quiz__field">';
        html += '<span class="fc-quiz__field-label">Mobile number <span class="fc-quiz__field-optional">(optional)</span></span>';
        html += '<input class="fc-quiz__input fc-quiz__input--text" type="tel" name="phone" autocomplete="tel" placeholder="04xx xxx xxx" value="' + escAttr( val.phone || '' ) + '">';
        html += '</label>';
        html += '</div>';

        // Consent is part of this final screen — one submit, no extra step.
        var checked = answers.consent === true;
        html += '<label class="fc-quiz__consent">';
        html += '<input class="fc-quiz__consent-input" type="checkbox" name="consent"' + ( checked ? ' checked' : '' ) + '>';
        html += '<span class="fc-quiz__consent-box" aria-hidden="true"></span>';
        html += '<span class="fc-quiz__consent-text">' + escHtml( step.consentLabel || 'I agree to the terms above.' ) + '</span>';
        html += '</label>';
        html += '<p class="fc-quiz__consent-fine">By submitting this assessment you authorise the clinical team to review your responses. Your information is handled in accordance with the Australian Privacy Act. You can withdraw at any time.</p>';

        var valid = isValidContact( val ) && checked;
        html += '<div class="fc-quiz__actions"><button class="fc-btn fc-btn--primary fc-quiz__continue" type="button" ' + ( ! valid ? 'disabled' : '' ) + '>Submit for clinical review</button></div>';
        return html;
    }

    function isValidContact( v ) {
        if ( ! v || ! v.name || ! v.email ) return false;
        // Light email check — server-side will validate properly.
        return /.+@.+\..+/.test( v.email );
    }

    /* ── Pathway preview ───────────────────────────────────────── */

    function renderPathway() {
        var result = calculateResult();

        var headline, body, ctaLabel, ctaHref, note;
        if ( result.state === 'unsuitable' ) {
            // Skip pathway framing for unsuitable — render the safety result
            // in place. (Do NOT advance the cursor: the pathway node is the
            // last item in the sequence, so cursor++ would land on nothing and
            // leave the user stuck on the consent screen.)
            renderResult();
            return;
        }

        if ( result.state === 'review' ) {
            // Outcome B — clinician should review closely. Continue to the
            // clinical intake; the team will flag for clinician review.
            headline  = 'Almost done — a clinician will review closely';
            body      = 'Based on your answers, an Australian-registered clinician should review your information carefully before recommending a pathway. Everything you’ve told us has been saved — a few final details (date of birth, medical history, and consent) complete your clinical record.';
            ctaLabel  = 'Finish my clinical record';
            ctaHref   = cfg.reviewUrl;
            if ( window.fcTrack ) fcTrack( 'routed_needs_review' );
            note      = 'Follow-up typically arranged within 1\u20132 business days. Final suitability is determined after clinical review.';
        } else {
            // Outcome A — likely suitable; continue straight into the
            // clinical intake (no separate booking step in the MVP funnel).
            headline  = 'Almost done — complete your clinical record';
            body      = 'Based on your answers you may be suitable for a clinician-led pathway. You’re not starting again: everything you’ve told us carries over. A few final details — date of birth, medical history, and consent — take about 5 minutes and complete the record your clinician reviews.';
            ctaLabel  = 'Finish my clinical record';
            ctaHref   = cfg.checkoutUrl;
            note      = 'Completing your record is not approval. Final suitability is determined after clinical review.';
            if ( window.fcTrack ) fcTrack( 'routed_likely_suitable' );
        }

        var html = '<div class="fc-intake__screen fc-intake__screen--pathway">';
        html += '<span class="fc-intake__eyebrow">Recommended pathway</span>';
        html += '<h2 class="fc-intake__headline fc-intake__headline--h2">' + escHtml( headline ) + '</h2>';
        html += '<p class="fc-intake__body">' + escHtml( body ) + '</p>';

        html += '<ol class="fc-intake__pathway-steps">';
        html += '<li class="fc-intake__pathway-step">' +
            '<span class="fc-intake__pathway-num">1</span>' +
            '<div><strong>Finish your clinical record</strong><p>Your quiz answers carry over — just confirm a few final details.</p></div>' +
        '</li>';
        html += '<li class="fc-intake__pathway-step">' +
            '<span class="fc-intake__pathway-num">2</span>' +
            '<div><strong>Clinician review</strong><p>A registered Australian clinician reviews your answers and decides next steps.</p></div>' +
        '</li>';
        html += '<li class="fc-intake__pathway-step">' +
            '<span class="fc-intake__pathway-num">3</span>' +
            '<div><strong>Ongoing support</strong><p>If appropriate, a plan with check-ins, monitoring and follow-up — not a one-off transaction.</p></div>' +
        '</li>';
        html += '</ol>';

        // Optional BMI line (non-pushy, factual only).
        if ( result.bmi ) {
            html += '<p class="fc-intake__pathway-bmi">Estimated BMI: <strong>' + result.bmi.toFixed( 1 ) + '</strong>. A clinician will confirm this with verified measurements.</p>';
        }

        var trackName = result.state === 'review' ? 'follow_up_clicked' : 'intake_continuation_clicked';
        html += '<a href="' + escAttr( ctaHref ) + '" class="fc-btn fc-btn--primary fc-intake__cta" data-fc-track="' + escAttr( trackName ) + '">' + escHtml( ctaLabel ) + '</a>';
        html += '<p class="fc-intake__fine">' + escHtml( note ) + '</p>';
        html += '<p class="fc-intake__compliance">Not all patients are approved. This is not a prescription or a guarantee of treatment.</p>';
        html += '</div>';

        viewport.innerHTML = html;

        // Click handler on the primary CTA so we emit the journey event
        // and hand off context (outcome + answers) to /patient-intake/ via
        // sessionStorage — the intake reads this on load and shows a
        // continuation welcome rather than a fresh start.
        var primaryCta = viewport.querySelector( '.fc-intake__cta' );
        if ( primaryCta ) {
            primaryCta.addEventListener( 'click', function () {
                try {
                    sessionStorage.setItem( 'fc_quiz_outcome', JSON.stringify( {
                        outcome:     result.state,
                        bmi:         result.bmi,
                        answers:     answers,
                        completedAt: Date.now(),
                    } ) );
                } catch ( e ) { /* storage blocked — intake falls back to generic welcome */ }
                if ( window.fcTrack ) fcTrack( trackName );
                if ( window.fcTrack ) fcTrack( 'quiz_to_intake_transition', { outcome: result.state } );
                disarmAbandonTracking();
            } );
        }

        if ( window.fcTrack ) fcTrack( 'pathway_viewed', { state: result.state, bmi: result.bmi } );
    }

    /* ── Result (unsuitable handoff) ───────────────────────────── */

    function renderResult() {
        var result = calculateResult();

        var html = '<div class="fc-intake__screen fc-intake__screen--result fc-intake__screen--result--' + result.state + '">';

        if ( result.state === 'unsuitable' ) {
            // Outcome C — safety flag; direct to clinic or GP.
            if ( window.fcTrack ) fcTrack( 'routed_not_suitable' );

            html += '<div class="fc-intake__result-icon fc-intake__result-icon--unsuitable" aria-hidden="true">' +
                '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>' +
            '</div>';
            html += '<span class="fc-intake__eyebrow">A different pathway is safer</span>';
            html += '<h2 class="fc-intake__headline fc-intake__headline--h2">A different pathway may be safer for you</h2>';
            html += '<p class="fc-intake__body">Based on your answers, this telehealth pathway may not be the right fit right now. This is not a medical diagnosis — it is a safety step. Your wellbeing comes first.</p>';
            html += '<p class="fc-intake__body fc-intake__body--muted">We recommend speaking with the clinic or your GP about the most appropriate options for your situation. Our care team is available to help you find a safe next step.</p>';
            html += '<a href="' + escAttr( cfg.contactUrl ) + '" class="fc-btn fc-btn--primary fc-intake__cta" data-fc-track="contact_clicked">Speak with the clinic</a>';
            html += '<p class="fc-intake__fine">Final suitability is determined after clinical review. If you believe this result is incorrect, our care team is happy to help.</p>';
        }

        html += '</div>';
        viewport.innerHTML = html;
        setImage( 'review', {
            text: 'Your safety comes first.',
            attribution: 'Weight Loss Clinic · Clinical support',
        } );
    }

    /* ── Result Calculation ────────────────────────────────────── */

    function calculateResult() {
        var medicalAnswers = answers.medical || [];
        var hasUnsuitable  = false;
        var hasReview      = false;
        var bmi            = null;

        var medStep = questions.find( function ( s ) { return s.id === 'medical'; } );
        if ( medStep ) {
            medStep.options.forEach( function ( opt ) {
                if ( medicalAnswers.indexOf( opt.value ) !== -1 ) {
                    if ( opt.flag === 'unsuitable' ) hasUnsuitable = true;
                    if ( opt.flag === 'review' )     hasReview = true;
                }
            } );
        }

        if ( answers.height && answers.weight ) {
            var heightCm = parseInt( answers.height, 10 );
            var weightKg = parseInt( answers.weight, 10 );
            if ( heightCm > 0 ) {
                var heightM = heightCm / 100;
                bmi = Math.round( ( weightKg / ( heightM * heightM ) ) * 10 ) / 10;
            }
        }

        if ( hasUnsuitable ) return { state: 'unsuitable', bmi: bmi };
        if ( hasReview )     return { state: 'review', bmi: bmi };
        if ( answers.age === '60+' ) return { state: 'review', bmi: bmi };
        if ( bmi !== null && bmi < 25 ) return { state: 'review', bmi: bmi };

        return { state: 'eligible', bmi: bmi };
    }

    /* ── Event wiring per question ─────────────────────────────── */

    function attachStepListeners( step ) {
        if ( step.type === 'select' ) {
            viewport.querySelectorAll( '.fc-quiz__option' ).forEach( function ( btn ) {
                btn.addEventListener( 'click', function () {
                    var clicked = this;
                    setAnswer( step, clicked.getAttribute( 'data-value' ) );
                    viewport.querySelectorAll( '.fc-quiz__option' ).forEach( function ( b ) {
                        b.classList.remove( 'is-selected', 'is-firing' );
                    } );
                    clicked.classList.add( 'is-selected', 'is-firing' );
                    registerAnswer( step );
                    var pauseMs = prefersReducedMotion() ? 0 : 480;
                    setTimeout( advance, pauseMs );
                } );
            } );
        } else if ( step.type === 'multiselect' ) {
            var continueBtn = viewport.querySelector( '.fc-quiz__continue' );
            viewport.querySelectorAll( '.fc-quiz__option' ).forEach( function ( btn ) {
                btn.addEventListener( 'click', function () {
                    var val       = this.getAttribute( 'data-value' );
                    var exclusive = this.getAttribute( 'data-exclusive' ) === 'true';
                    var current   = getAnswer( step ) || [];

                    if ( exclusive ) {
                        current = [ val ];
                        viewport.querySelectorAll( '.fc-quiz__option' ).forEach( function ( b ) {
                            b.classList.remove( 'is-selected' );
                        } );
                        this.classList.add( 'is-selected' );
                    } else {
                        current = current.filter( function ( v ) {
                            var optDef = step.options.find( function ( o ) { return o.value === v; } );
                            return optDef && ! optDef.exclusive;
                        } );
                        var idx = current.indexOf( val );
                        if ( idx !== -1 ) {
                            current.splice( idx, 1 );
                            this.classList.remove( 'is-selected' );
                        } else {
                            current.push( val );
                            this.classList.add( 'is-selected' );
                        }
                        viewport.querySelectorAll( '.fc-quiz__option[data-exclusive="true"]' ).forEach( function ( b ) {
                            b.classList.remove( 'is-selected' );
                        } );
                    }

                    setAnswer( step, current );
                    continueBtn.disabled = current.length === 0;
                } );
            } );
            continueBtn.addEventListener( 'click', function () {
                if ( ! this.disabled ) {
                    registerAnswer( step );
                    advance();
                }
            } );
        } else if ( step.type === 'body' ) {
            var bodyInputs  = viewport.querySelectorAll( '.fc-quiz__input' );
            var bodyBtn     = viewport.querySelector( '.fc-quiz__continue' );

            bodyInputs.forEach( function ( el ) {
                el.addEventListener( 'input', function () {
                    answers[ this.getAttribute( 'data-key' ) ] = this.value;
                    bodyBtn.disabled = ! isValidBody( step );
                } );
                el.addEventListener( 'keydown', function ( e ) {
                    if ( e.key === 'Enter' && isValidBody( step ) ) {
                        registerAnswer( step );
                        advance();
                    }
                } );
            } );
            bodyBtn.addEventListener( 'click', function () {
                if ( ! this.disabled ) {
                    registerAnswer( step );
                    advance();
                }
            } );
            bodyInputs[ 0 ].focus();
        } else if ( step.type === 'input' ) {
            var freeInput = viewport.querySelector( '.fc-quiz__input' );
            var freeBtn   = viewport.querySelector( '.fc-quiz__continue' );

            freeInput.addEventListener( 'input', function () {
                setAnswer( step, this.value );
                freeBtn.disabled = ! ( step.optional || String( this.value ).trim() !== '' );
            } );
            freeInput.addEventListener( 'keydown', function ( e ) {
                if ( e.key === 'Enter' && step.inputType !== 'textarea' && ! freeBtn.disabled ) {
                    e.preventDefault();
                    registerAnswer( step );
                    advance();
                }
            } );
            freeBtn.addEventListener( 'click', function () {
                if ( ! this.disabled ) {
                    registerAnswer( step );
                    advance();
                }
            } );
            freeInput.focus();
        } else if ( step.type === 'contact' ) {
            var contactInputs = viewport.querySelectorAll( '.fc-quiz__contact input' );
            var consentBox    = viewport.querySelector( '.fc-quiz__consent-input' );
            var contactBtn    = viewport.querySelector( '.fc-quiz__continue' );

            function readContact() {
                var v = { name: '', email: '', phone: '' };
                contactInputs.forEach( function ( el ) {
                    v[ el.name ] = ( el.value || '' ).trim();
                } );
                return v;
            }

            function updateContact() {
                var v = readContact();
                answers[ step.id ] = v;
                answers.consent    = !! ( consentBox && consentBox.checked );
                contactBtn.disabled = ! ( isValidContact( v ) && answers.consent );
            }

            contactInputs.forEach( function ( el ) {
                el.addEventListener( 'input', updateContact );
                el.addEventListener( 'keydown', function ( e ) {
                    if ( e.key === 'Enter' && ! contactBtn.disabled ) {
                        e.preventDefault();
                        registerAnswer( step );
                        advance();
                    }
                } );
            } );
            if ( consentBox ) consentBox.addEventListener( 'change', updateContact );
            contactBtn.addEventListener( 'click', function () {
                if ( ! this.disabled ) {
                    registerAnswer( step );
                    advance();
                }
            } );
            contactInputs[ 0 ].focus();
        }
    }

    function registerAnswer( step ) {
        // Only count each question once.
        if ( ! step._counted ) {
            answeredCount++;
            step._counted = true;
        }
        if ( window.fcTrack ) {
            fcTrack( 'assessment_step_completed', {
                step_id: step.id,
                step_index: answeredCount,
                total_steps: totalQuestions,
            } );
        }

        // The contact + consent step is the final data point — submit the
        // whole assessment to the server now (persists to the Patients record
        // and creates a Gravity Forms entry → notifications + ActiveCampaign).
        if ( step.id === 'contact' ) {
            submitQuiz();
        }
    }

    /* ── Server submission ──────────────────────────────────────────
       Sends the completed assessment to WordPress. Guarded so it only
       fires once. Degrades silently if the config isn't present (e.g.
       the plugin isn't active) — the client flow is unaffected. */
    var quizSubmitted = false;
    function submitQuiz() {
        if ( quizSubmitted ) return;
        var cfgWp = window.wlcQuiz;
        if ( ! cfgWp || ! cfgWp.ajax_url || ! cfgWp.nonce ) return;
        if ( ! answers.contact || ! answers.contact.email ) return;
        quizSubmitted = true;

        var body = new FormData();
        body.append( 'action', 'wlc_quiz_submit' );
        body.append( 'nonce', cfgWp.nonce );
        body.append( 'answers', JSON.stringify( answers ) );

        try {
            fetch( cfgWp.ajax_url, {
                method: 'POST',
                body: body,
                credentials: 'same-origin',
                keepalive: true,
            } ).then( function ( r ) {
                return r.json();
            } ).then( function ( res ) {
                if ( window.fcTrack ) {
                    fcTrack( 'quiz_submitted_server', {
                        outcome: res && res.data ? res.data.outcome : null,
                    } );
                }
            } ).catch( function () { /* network error — non-blocking */ } );
        } catch ( e ) { /* fetch unsupported — non-blocking */ }
    }

    /* ── Navigation ────────────────────────────────────────────── */

    function advance() {
        if ( ! quizStarted ) {
            quizStarted = true;
            if ( window.fcTrack ) {
                fcTrack( 'assessment_started' );
                fcTrack( 'quiz_started' );
            }
            armAbandonTracking();
        }

        if ( cursor >= sequence.length - 1 ) {
            // End of sequence — recompute result.
            if ( window.fcTrack ) {
                fcTrack( 'assessment_submitted' );
                fcTrack( 'quiz_completed' );
            }
            disarmAbandonTracking();
            return;
        }

        cursor++;
        renderCurrent();
    }

    /* ── Abandon tracking ──────────────────────────────────────────
       Fires once if the user leaves before reaching a result. */
    var abandonArmed = false;
    function onAbandon() {
        if ( ! abandonArmed ) return;
        abandonArmed = false;
        try {
            if ( window.fcTrack ) {
                fcTrack( 'assessment_abandoned', {
                    answered: answeredCount,
                    total: totalQuestions,
                } );
            }
        } catch ( e ) { /* silent */ }
    }
    function armAbandonTracking() {
        if ( abandonArmed ) return;
        abandonArmed = true;
        window.addEventListener( 'pagehide', onAbandon, { once: true } );
        window.addEventListener( 'beforeunload', onAbandon, { once: true } );
    }
    function disarmAbandonTracking() {
        abandonArmed = false;
    }

    backBtn.addEventListener( 'click', function () {
        if ( cursor > 0 ) {
            var prev = sequence[ cursor ];
            // If the screen we're leaving is a question, uncount it.
            if ( prev && prev.type && prev._counted ) {
                answeredCount = Math.max( 0, answeredCount - 1 );
                prev._counted = false;
            }
            cursor--;
            renderCurrent();
        }
    } );

    /* ── Helpers ───────────────────────────────────────────────── */

    function prefersReducedMotion() {
        return !! ( window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches );
    }

    function escHtml( str ) {
        var d = document.createElement( 'div' );
        d.textContent = str;
        return d.innerHTML;
    }

    function escAttr( str ) {
        return String( str )
            .replace( /&/g, '&amp;' )
            .replace( /"/g, '&quot;' )
            .replace( /'/g, '&#39;' )
            .replace( /</g, '&lt;' )
            .replace( />/g, '&gt;' );
    }

    /* ── Init ──────────────────────────────────────────────────── */

    // Disable browser scroll restoration so refreshing /quiz/ never
    // lands the user mid-page. We control scroll position ourselves.
    if ( 'scrollRestoration' in history ) {
        history.scrollRestoration = 'manual';
    }
    // Initial load: jump to the top of the assessment. Use instant
    // scroll to defeat any CSS smooth-scroll default.
    if ( document.documentElement ) document.documentElement.scrollTop = 0;
    if ( document.body )            document.body.scrollTop            = 0;
    window.scrollTo( 0, 0 );

    // Belt-and-braces: if the page is restored from the back-forward
    // cache (Safari/Firefox especially), force the top again so the
    // user never lands mid-flow.
    window.addEventListener( 'pageshow', function ( e ) {
        if ( e.persisted ) {
            window.scrollTo( 0, 0 );
        }
    } );

    renderCurrent();

} )();
