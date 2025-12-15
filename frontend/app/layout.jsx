import './globals.css';
import Providers from './providers';

export const metadata = {
  title: 'SOP System',
  description: 'Standard Operating Procedure management for Cambodia-focused workflows.',
};

export default function RootLayout({ children }) {
  return (
    <html lang="en">
      <body>
        <Providers>{children}</Providers>
      </body>
    </html>
  );
}
