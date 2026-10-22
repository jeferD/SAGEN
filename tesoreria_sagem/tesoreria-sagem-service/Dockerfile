FROM amazoncorretto:17
VOLUME /temp
EXPOSE 9163
ADD ./target/tesoreria-sagem-service-0.0.1-SNAPSHOT.jar tesoreria-sagem-service.jar
ENTRYPOINT [ "java", "-jar", "/tesoreria-sagem-service.jar" ]
