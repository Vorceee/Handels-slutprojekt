import LoadCompanies from "/Components/loadCompanies";
import MainMenu from "/Components/MainMenu";
import FooterMenu from "/Components/FooterMenu";
import React from "react";
import { useState, useEffect } from "react";
import { PrismaClient } from "@prisma/client";
const prisma = new PrismaClient();

function company({ placement, sponsors }) {
  return (
    <>
      <MainMenu />

      <LoadCompanies {...placement} />

      <FooterMenu sponsors={sponsors} />
    </>
  );
}
export async function getStaticPaths() {
  const data = await prisma.company.findMany({ orderBy: [{ id: "asc" }] });
  const companies = [...JSON.parse(JSON.stringify(data))];

  const paths = companies.map((comany) => ({
    params: { id: comany.id.toString() },
  }));

  return { paths, fallback: false };
}
export async function getStaticProps({ params }) {
  const data = await prisma.company.findUnique({
    where: { id: parseInt(params.id) },
  });
  const sponsors = await prisma.sponsors.findMany();
  const location = await prisma.placement.findMany({
    orderBy: [{ id: "asc" }],
  });
  const placement = data;

  return {
    props: {
      placement,
      sponsors: [...JSON.parse(JSON.stringify(sponsors))],
      location: [...JSON.parse(JSON.stringify(location))],
    },
  };
}

export default company;
