FROM amazoncorretto:17
VOLUME /temp
EXPOSE 9163
ADD ./target/tesoreria-sagem-backend-0.0.1-SNAPSHOT.jar tesoreria-sagem-backend.jar
ENTRYPOINT [ "java", "-jar", "/tesoreria-sagem-backend.jar" ]
