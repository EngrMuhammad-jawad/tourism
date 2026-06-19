document.addEventListener('DOMContentLoaded', () => {
  const defaultLang = 'en';
  let currentLang = localStorage.getItem('site_lang') || defaultLang;

  const loadTranslations = async (lang) => {
    try {
      const response = await fetch(`locales/${lang}.json`);
      if (!response.ok) throw new Error('Network response was not ok');
      const translations = await response.json();
      applyTranslations(translations);
      setLanguageAttributes(lang);
    } catch (error) {
      console.error('Error loading translations:', error);
      // Fallback to English if fails
      if (lang !== 'en') loadTranslations('en');
    }
  };

  const applyTranslations = (translations) => {
    const elements = document.querySelectorAll('[data-i18n]');
    elements.forEach((el) => {
      const key = el.getAttribute('data-i18n');
      if (translations[key]) {
        // Special case for placeholders
        if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
          el.placeholder = translations[key];
        } else {
          el.textContent = translations[key];
        }
      }
    });
  };

  const setLanguageAttributes = (lang) => {
    document.documentElement.lang = lang;
    if (lang === 'ar') {
      document.documentElement.dir = 'rtl';
    } else {
      document.documentElement.dir = 'ltr';
    }
  };

  const changeLanguage = (lang) => {
    currentLang = lang;
    localStorage.setItem('site_lang', lang);
    loadTranslations(lang);
  };

  // Attach to global window object so it can be called from HTML onclick
  window.changeLanguage = changeLanguage;

  // Initialize
  loadTranslations(currentLang);
});
