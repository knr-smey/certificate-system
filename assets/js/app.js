/**
 * Certificate System - App JS
 * MVC API Structure Example
 */

console.log("Certificate System JS Loaded");

/**
 * Fetch Classes via API
 * @param {string} type - 'normal', 'free', or 'scholarship'
 * @param {string} course - optional course filter
 */
async function fetchClasses(type = 'normal', course = '') {
  try {
    const url = new URL('/api/classes', window.location.origin);
    url.searchParams.append('type', type);
    if (course) url.searchParams.append('course', course);

    const response = await fetch(url);
    const result = await response.json();

    if (!result.ok) {
      console.error('API Error:', result.error);
      return [];
    }

    console.log('Classes:', result.data);
    return result.data;
  } catch (error) {
    console.error('Fetch error:', error);
    return [];
  }
}

/**
 * Fetch Students by Class
 * @param {number} classId - The class ID
 */
async function fetchStudents(classId) {
  if (!classId || classId <= 0) {
    console.error('Invalid classId');
    return [];
  }

  try {
    const url = new URL('/api/students', window.location.origin);
    url.searchParams.append('class_id', classId);

    const response = await fetch(url);
    const result = await response.json();

    if (!result.ok) {
      console.error('API Error:', result.error);
      return [];
    }

    console.log('Students:', result.data);
    return result.data;
  } catch (error) {
    console.error('Fetch error:', error);
    return [];
  }
}

// Example Usage:
// fetchClasses('normal').then(classes => console.log(classes));
// fetchStudents(1).then(students => console.log(students));

/**
 * Form Validation Module
 * Validates form fields and shows error messages
 */

/**
 * Show error message for a field
 * @param {HTMLElement} field - The form field element
 * @param {string} message - Error message to display
 */
function showFieldError(field, message) {
    // Remove existing error
    const existingError = field.parentNode.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }
    
    // Remove error class
    field.classList.remove('error');
    
    // Create error element
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    
    // Insert after the field
    field.parentNode.appendChild(errorDiv);
    
    // Add error class for styling
    field.classList.add('error');
}

/**
 * Clear error message for a field
 * @param {HTMLElement} field - The form field element
 */
function clearFieldError(field) {
    const existingError = field.parentNode.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }
    field.classList.remove('error');
}

/**
 * Validate text field is not empty
 * @param {HTMLElement} field - The input field
 * @returns {boolean}
 */
function validateTextField(field) {
    const value = field.value.trim();
    if (!value) {
        showFieldError(field, 'This field is required');
        return false;
    }
    clearFieldError(field);
    return true;
}

/**
 * Validate select field has a value selected
 * @param {HTMLElement} field - The select field
 * @returns {boolean}
 */
function validateSelectField(field) {
    const value = field.value.trim();
    if (!value) {
        showFieldError(field, 'Please select an option');
        return false;
    }
    clearFieldError(field);
    return true;
}

/**
 * Validate form on submit
 * @param {Event} event - Form submit event
 * @returns {boolean}
 */
function validateForm(event) {
    const form = event.target;
    const studentName = form.querySelector('#student_name');
    const course = form.querySelector('#course');
    
    let isValid = true;
    
    // Validate student name
    if (!validateTextField(studentName)) {
        isValid = false;
    }
    
    // Validate course selection
    if (!validateSelectField(course)) {
        isValid = false;
    }
    
    // If form is invalid, prevent submission
    if (!isValid) {
        event.preventDefault();
        
        // Focus on first invalid field
        const firstError = form.querySelector('.error');
        if (firstError) {
            firstError.focus();
        }
        
        return false;
    }
    
    return true;
}

/**
 * Initialize form validation when DOM is ready
 */
document.addEventListener('DOMContentLoaded', function() {
    // Find all forms with validation
    const forms = document.querySelectorAll('form');
    
    forms.forEach(function(form) {
        form.addEventListener('submit', validateForm);
        
        // Clear error on input/change
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(function(input) {
            input.addEventListener('input', function() {
                clearFieldError(this);
            });
            input.addEventListener('change', function() {
                clearFieldError(this);
            });
        });
    });
});
