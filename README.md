# DriveOffGrid - Travel & Tour Booking Website

A high-performance, mobile-first travel and tour booking website built with static HTML, CSS, and JavaScript.

## 🚀 Performance Optimizations

### Image Optimization
- **Lazy Loading**: All non-critical images use native lazy loading with fallback
- **Priority Loading**: Hero image uses `loading="eager"` and `fetchpriority="high"`
- **Responsive Images**: Images are optimized for different screen sizes
- **Format Optimization**: Ready for WebP conversion (recommended for production)

### CSS Optimizations
- **Mobile-First Approach**: Styles start from mobile and scale up
- **Efficient Selectors**: Minimal CSS specificity for faster rendering
- **Critical CSS**: Inline critical styles or minimal external CSS
- **No Heavy Frameworks**: Vanilla CSS for maximum performance
- **CSS Variables**: Efficient theming and maintainability

### JavaScript Optimizations
- **Event Delegation**: Efficient event handling
- **Passive Event Listeners**: Smooth scrolling without blocking
- **Intersection Observer**: Efficient scroll-based animations
- **Debounced Scroll Events**: Optimized header effects
- **Minimal Dependencies**: No external libraries required

### General Optimizations
- **Semantic HTML5**: Better SEO and accessibility
- **Progressive Enhancement**: Works without JavaScript
- **Reduced Motion Support**: Respects user preferences
- **Efficient Font Loading**: Google Fonts with `display=swap`
- **Preconnect**: DNS prefetching for external resources

## 📁 Project Structure

```
DOG/
├── index.html              # Homepage
├── css/
│   └── style.css          # Main stylesheet (mobile-first)
├── js/
│   └── main.js            # Main JavaScript
├── assets/
│   └── images/
│       └── homepage/      # Homepage images
└── README.md              # This file
```

## 🎨 Design Features

- **Mobile-First Responsive Design**: Optimized for mobile → tablet → laptop → desktop
- **Modern UI/UX**: Clean, professional design with smooth animations
- **Accessibility**: ARIA labels, semantic HTML, keyboard navigation
- **Color Scheme**: Orange (#FF6B35) accent with dark/light theme

## 📱 Responsive Breakpoints

- **Mobile**: < 768px (default, mobile-first)
- **Tablet**: 768px - 1023px
- **Laptop**: 1024px - 1199px
- **Desktop**: 1200px+

## 🛠️ Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- IE11+ (with graceful degradation)
- Mobile browsers (iOS Safari, Chrome Mobile)

## 📄 Pages

- **Homepage** (`index.html`) - Complete landing page
- **Blog** (`blog.html`) - Coming soon
- **Testimonials** (`testimonials.html`) - Coming soon
- **Gallery** (`gallery.html`) - Coming soon
- **Locations** (`locations.html`) - Coming soon
- **Contact** (`contact.html`) - Coming soon

## 🚀 Getting Started

1. **Clone or download** this repository
2. **Open** `index.html` in a web browser
3. **For development server** (recommended):
   ```bash
   # Using Python
   python -m http.server 8000
   
   # Using Node.js (http-server)
   npx http-server -p 8000
   ```

## 📈 Performance Tips for Production

1. **Image Optimization**:
   - Convert images to WebP format
   - Use responsive images with `srcset`
   - Compress images (TinyPNG, ImageOptim)

2. **CSS Optimization**:
   - Minify CSS for production
   - Remove unused CSS
   - Consider critical CSS extraction

3. **JavaScript Optimization**:
   - Minify JavaScript
   - Use code splitting if needed
   - Consider service workers for offline support

4. **Server Optimization**:
   - Enable GZIP/Brotli compression
   - Use CDN for static assets
   - Implement caching headers
   - Consider HTTP/2 or HTTP/3

5. **Font Optimization**:
   - Self-host fonts for better control
   - Use font-display: swap
   - Subset fonts to include only needed characters

## 🔧 Customization

### Colors
Edit CSS variables in `css/style.css`:
```css
:root {
    --primary-color: #FF6B35;
    --text-dark: #1A1A1A;
    --text-light: #FFFFFF;
    /* ... */
}
```

### Content
- Update text content in `index.html`
- Replace images in `assets/images/homepage/`
- Modify navigation links in header and footer

## 📝 Notes

- All images are currently using placeholder paths from `assets/images/homepage/`
- Form submissions are currently logged to console (implement backend as needed)
- Testimonials slider works on mobile with touch scrolling
- Mobile menu closes on link click or outside click

## 🎯 Future Enhancements

- [ ] Add remaining pages (Blog, Gallery, Testimonials, Locations, Contact)
- [ ] Implement backend for form submissions
- [ ] Add image optimization pipeline
- [ ] Implement service worker for offline support
- [ ] Add analytics integration
- [ ] SEO optimization (meta tags, structured data)

## 📄 License

This project is open source and available for use.

---

**DriveOffGrid** - Where Luxury Meets The Open Road

