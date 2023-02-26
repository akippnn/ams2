FROM tomsik68/xampp:8

# Install OpenSSL
RUN apt-get update && \
    apt-get install -y openssl && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Create a certificate
RUN openssl req -x509 -newkey rsa:4096 -keyout /opt/lampp/etc/ssl.key/server.key \
    -out /opt/lampp/etc/ssl.crt/server.crt -days 365 -nodes -subj "/CN=localhost"

# Configure XAMPP to use SSL
RUN sed -i -e 's/#LoadModule ssl_module/LoadModule ssl_module/' \
    -e 's/#LoadModule socache_shmcb_module/LoadModule socache_shmcb_module/' \
    -e 's/#Listen 443/Listen 443/' \
    -e 's/#ServerName www.example.com:443/ServerName localhost/' \
    -e 's/#SSLCertificateFile/SSLCertificateFile/' \
    -e 's/#SSLCertificateKeyFile/SSLCertificateKeyFile/' \
    /opt/lampp/etc/httpd.conf && \
    sed -i 's:SSLCertificateFile "/opt/lampp/etc/ssl.crt/server.crt":SSLCertificateFile "/opt/lampp/etc/ssl.crt/server.crt":' /opt/lampp/etc/httpd.conf && \
    sed -i 's:SSLCertificateKeyFile "/opt/lampp/etc/ssl.key/server.key":SSLCertificateKeyFile "/opt/lampp/etc/ssl.key/server.key":' /opt/lampp/etc/httpd.conf

# Configure XAMPP to add include paths
RUN sed -i 's|;include_path = ".:/php/includes"|include_path = ".:/opt/lampp/lib/php:/opt/lampp/htdocs:/opt/lampp/htdocs/www"|g' /opt/lampp/etc/php.ini

# Apache to enable .htaccess override
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /opt/lampp/etc/httpd.conf 

# Expose new ports
EXPOSE 3306
EXPOSE 443
EXPOSE 22
EXPOSE 80