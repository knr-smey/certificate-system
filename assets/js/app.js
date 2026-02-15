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
