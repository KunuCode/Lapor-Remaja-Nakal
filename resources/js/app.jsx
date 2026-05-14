import React from 'react';
import { createRoot } from 'react-dom/client';

const App = () => {
    return (
        <div style={{ padding: 20, textAlign: 'center' }}>
            <h1 style={{ color: 'green' }}>SUCCESS</h1>
            <p>Aplikasi berjalan.</p>
        </div>
    );
};

const container = document.getElementById('app');
if (container) {
    createRoot(container).render(<App />);
}