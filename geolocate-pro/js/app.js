/**
 * GeoLocate Pro - Main JavaScript
 * Handles animations, map interactions, and geolocation features
 * 
 * @author Claude
 * @version 1.0
 */

// =============================================
// SCROLL ANIMATIONS
// =============================================

/**
 * Initialize Intersection Observer for scroll animations
 */
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                
                // Optional: Stop observing after animation
                // observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe all elements with fade-in class
    document.querySelectorAll('.fade-in').forEach(element => {
        observer.observe(element);
    });
}

// =============================================
// SMOOTH SCROLL
// =============================================

/**
 * Initialize smooth scrolling for anchor links
 */
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const target = document.querySelector(targetId);
            
            if (target) {
                const headerOffset = 80; // Height of fixed header
                const elementPosition = target.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// =============================================
// GEOLOCATION HANDLING
// =============================================

/**
 * Get user's current position
 * @param {Function} successCallback
 * @param {Function} errorCallback
 */
function getUserLocation(successCallback, errorCallback) {
    if ('geolocation' in navigator) {
        const options = {
            enableHighAccuracy: true,
            timeout: 5000,
            maximumAge: 0
        };
        
        navigator.geolocation.getCurrentPosition(
            successCallback,
            errorCallback,
            options
        );
    } else {
        console.error('Geolocation is not supported by this browser');
        if (errorCallback) {
            errorCallback(new Error('Geolocation not supported'));
        }
    }
}

/**
 * Watch user's position continuously
 * @param {Function} successCallback
 * @param {Function} errorCallback
 * @returns {number} Watch ID
 */
function watchUserLocation(successCallback, errorCallback) {
    if ('geolocation' in navigator) {
        const options = {
            enableHighAccuracy: true,
            timeout: 5000,
            maximumAge: 0
        };
        
        return navigator.geolocation.watchPosition(
            successCallback,
            errorCallback,
            options
        );
    }
    return null;
}

/**
 * Stop watching user's position
 * @param {number} watchId
 */
function stopWatchingLocation(watchId) {
    if (watchId && 'geolocation' in navigator) {
        navigator.geolocation.clearWatch(watchId);
    }
}

// =============================================
// MAP INITIALIZATION
// =============================================

let map = null;
let marker = null;
let infoWindow = null;

/**
 * Initialize Google Map
 * @param {Object} config - Configuration object with lat, lng, zoom, styles
 */
function initMap(config = {}) {
    const defaultConfig = {
        lat: 25.4232,
        lng: -100.9931,
        zoom: 13,
        mapId: 'map',
        locationName: 'Ubicación Predeterminada',
        styles: []
    };
    
    const settings = { ...defaultConfig, ...config };
    
    // Create map
    const mapElement = document.getElementById(settings.mapId);
    if (!mapElement) {
        console.error('Map element not found');
        return;
    }
    
    const mapOptions = {
        zoom: settings.zoom,
        center: { lat: settings.lat, lng: settings.lng },
        styles: settings.styles,
        mapTypeControl: true,
        streetViewControl: true,
        fullscreenControl: true,
        zoomControl: true
    };
    
    map = new google.maps.Map(mapElement, mapOptions);
    
    // Create marker
    marker = new google.maps.Marker({
        position: { lat: settings.lat, lng: settings.lng },
        map: map,
        title: settings.locationName,
        animation: google.maps.Animation.DROP
    });
    
    // Create info window
    infoWindow = new google.maps.InfoWindow({
        content: createInfoWindowContent(settings.locationName, settings.lat, settings.lng)
    });
    
    // Add click listener to marker
    marker.addListener('click', function() {
        infoWindow.open(map, marker);
    });
    
    // Try to get user's actual location
    getUserLocation(
        function(position) {
            const userLocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            
            updateMapLocation(userLocation, 'Tu Ubicación', position.coords.accuracy);
        },
        function(error) {
            console.log('Geolocation error:', error.message);
        }
    );
}

/**
 * Create info window content HTML
 * @param {string} title
 * @param {number} lat
 * @param {number} lng
 * @param {number} accuracy (optional)
 * @returns {string} HTML content
 */
function createInfoWindowContent(title, lat, lng, accuracy = null) {
    let content = `
        <div style="color: #0a192f; padding: 10px; font-family: 'DM Sans', sans-serif;">
            <h3 style="margin: 0 0 10px 0; font-family: 'Playfair Display', serif;">${title}</h3>
            <p style="margin: 5px 0; font-size: 0.9rem;">
                <strong>Latitud:</strong> ${lat.toFixed(6)}<br>
                <strong>Longitud:</strong> ${lng.toFixed(6)}
    `;
    
    if (accuracy) {
        content += `<br><strong>Precisión:</strong> ${Math.round(accuracy)} metros`;
    }
    
    content += `
            </p>
        </div>
    `;
    
    return content;
}

/**
 * Update map location
 * @param {Object} location - { lat, lng }
 * @param {string} title
 * @param {number} accuracy (optional)
 */
function updateMapLocation(location, title, accuracy = null) {
    if (map && marker && infoWindow) {
        map.setCenter(location);
        marker.setPosition(location);
        infoWindow.setContent(createInfoWindowContent(title, location.lat, location.lng, accuracy));
    }
}

/**
 * Add marker to map
 * @param {Object} location - { lat, lng }
 * @param {string} title
 * @param {string} content (optional)
 * @returns {google.maps.Marker}
 */
function addMarker(location, title, content = null) {
    const newMarker = new google.maps.Marker({
        position: location,
        map: map,
        title: title,
        animation: google.maps.Animation.DROP
    });
    
    if (content) {
        const newInfoWindow = new google.maps.InfoWindow({
            content: content
        });
        
        newMarker.addListener('click', function() {
            newInfoWindow.open(map, newMarker);
        });
    }
    
    return newMarker;
}

// =============================================
// UTILITY FUNCTIONS
// =============================================

/**
 * Calculate distance between two coordinates (Haversine formula)
 * @param {number} lat1
 * @param {number} lng1
 * @param {number} lat2
 * @param {number} lng2
 * @returns {number} Distance in kilometers
 */
function calculateDistance(lat1, lng1, lat2, lng2) {
    const R = 6371; // Radius of Earth in kilometers
    const dLat = toRadians(lat2 - lat1);
    const dLng = toRadians(lng2 - lng1);
    
    const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
              Math.cos(toRadians(lat1)) * Math.cos(toRadians(lat2)) *
              Math.sin(dLng / 2) * Math.sin(dLng / 2);
    
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    const distance = R * c;
    
    return distance;
}

/**
 * Convert degrees to radians
 * @param {number} degrees
 * @returns {number}
 */
function toRadians(degrees) {
    return degrees * (Math.PI / 180);
}

/**
 * Format coordinates for display
 * @param {number} lat
 * @param {number} lng
 * @param {number} decimals
 * @returns {string}
 */
function formatCoordinates(lat, lng, decimals = 6) {
    return `${lat.toFixed(decimals)}, ${lng.toFixed(decimals)}`;
}

/**
 * Show notification message
 * @param {string} message
 * @param {string} type - 'success', 'error', 'warning', 'info'
 * @param {number} duration - Duration in milliseconds
 */
function showNotification(message, type = 'info', duration = 3000) {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        padding: 1rem 1.5rem;
        background: ${getNotificationColor(type)};
        color: white;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        z-index: 10000;
        animation: slideInRight 0.3s ease;
        font-family: 'DM Sans', sans-serif;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, duration);
}

/**
 * Get notification color based on type
 * @param {string} type
 * @returns {string}
 */
function getNotificationColor(type) {
    const colors = {
        success: '#10b981',
        error: '#ef4444',
        warning: '#f59e0b',
        info: '#3b82f6'
    };
    return colors[type] || colors.info;
}

/**
 * Debounce function to limit function calls
 * @param {Function} func
 * @param {number} wait
 * @returns {Function}
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// =============================================
// PERFORMANCE MONITORING
// =============================================

/**
 * Log performance metrics
 */
function logPerformance() {
    if ('performance' in window) {
        const perfData = window.performance.timing;
        const pageLoadTime = perfData.loadEventEnd - perfData.navigationStart;
        const connectTime = perfData.responseEnd - perfData.requestStart;
        const renderTime = perfData.domComplete - perfData.domLoading;
        
        console.log('Performance Metrics:');
        console.log(`Page Load Time: ${pageLoadTime}ms`);
        console.log(`Connect Time: ${connectTime}ms`);
        console.log(`Render Time: ${renderTime}ms`);
    }
}

// =============================================
// INITIALIZATION
// =============================================

/**
 * Initialize all features when DOM is ready
 */
document.addEventListener('DOMContentLoaded', function() {
    // Initialize scroll animations
    initScrollAnimations();
    
    // Initialize smooth scroll
    initSmoothScroll();
    
    // Log performance (in development only)
    if (window.location.hostname === 'localhost') {
        window.addEventListener('load', logPerformance);
    }
    
    // Add CSS for animations
    addAnimationStyles();
});

/**
 * Add animation styles dynamically
 */
function addAnimationStyles() {
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
}

// Export functions for use in other scripts (if using modules)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        getUserLocation,
        watchUserLocation,
        stopWatchingLocation,
        initMap,
        updateMapLocation,
        addMarker,
        calculateDistance,
        formatCoordinates,
        showNotification,
        debounce
    };
}