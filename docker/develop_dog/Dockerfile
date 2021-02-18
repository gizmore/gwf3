FROM gwf3/testing_base

RUN mkdir /ircd
COPY miniircd /ircd/

COPY cli.sh /

EXPOSE 6667 6697

CMD [ "/cli.sh" ]
